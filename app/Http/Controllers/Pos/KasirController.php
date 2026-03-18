<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Meja;
use App\Models\Product;
use App\Models\Transaksi;
use App\Models\TransaksiProduct;
use App\Models\TransaksiProdukItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KasirController extends Controller
{
    public function indexes()
    {
        return view('pos.pos_view');
    }

    public function getKategori()
    {
        $data['kategori'] = Kategori::where('toko_id', Session::get('toko.id'))->get();
        return view('pos.respons.kategori', $data);
    }

    public function getProduk(Request $request, $kat)
    {
        $search = $request->query('search', '');
        $data['produk'] = Product::with('kategori')
            ->where('toko_id', Session::get('toko.id'))
            ->when($kat != 'all', function ($query) use ($kat) {
                $query->where('kategori_id', $kat);
            })
            ->when(!empty($search), function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')->orWhereHas('kategori', function ($k) use ($search) {
                        $k->where('name', 'like', '%' . $search . '%');
                    });
                });
            })
            ->get();
        $data['aktif'] = $this->_getActiveProduk($request->status, $request->meja);
        return view('pos.respons.produk', $data);
    }

    private function _getActiveProduk($status, $meja = '')
    {
        $transaksi = Transaksi::with('produkPivot')
            ->where('toko_id', Session::get('toko.id'))
            ->where('status', 'keranjang')
            ->when($status == 'ditempat', function ($query) use ($status) {
                $query->where('jenis_transaksi', 'ditempat');
            })
            ->when($status == 'pesanan', function ($query) use ($status) {
                $query->where('jenis_transaksi', 'pesanan');
            })
            ->when($meja != '', function ($query) use ($meja) {
                $query->where('meja_id', $meja);
            })
            ->first();

        if (!$transaksi) {
            return [];
        }

        return $transaksi->produkPivot()->pluck('produk_id')->toArray();
    }

    public function getKeranjang(Request $request)
    {
        $meja = $request->meja;
        $transaksi = Transaksi::with('produkPivot.produk')
            ->where('toko_id', Session::get('toko.id'))
            ->when($request->transaksi != '', fn($q) => $q->where('id', $request->transaksi))
            ->when($request->transaksi == '' && !empty($meja), fn($q) => $q->where('status', 'keranjang')->where('jenis_transaksi', 'ditempat')->where('meja_id', $meja))
            ->when($request->transaksi == '' && empty($meja), fn($q) => $q->where('status', 'keranjang')->where('jenis_transaksi', 'ditempat')->whereNull('meja_id'))
            ->first();

        $nama_file = $transaksi->kode_transaksi;
        $path = 'uploads/bukti_bayar/';
        $ekstensi = ['png', 'jpg', 'jpeg'];

        foreach ($ekstensi as $ext) {
            if (file_exists($path . $nama_file . '.' . $ext)) {
                $data['img'] = asset($path . $nama_file . '.' . $ext);
                break;
            }
        }

        $data['transaksi'] = optional($transaksi)->produkPivot ?? collect();
        $html = view('pos.respons.keranjang', $data)->render();

        return response()->json([
            'html' => $html,
            'transaksi' => $transaksi ? $transaksi : null,
            'img' => $data['img'] ?? null,
        ]);
    }

    public function postTransaksiDetail(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:products,id',
            'meja' => 'nullable|exists:mejas,id',
            'sub_total' => 'nullable|numeric',
        ]);

        DB::beginTransaction();
        try {
            // Ambil & lock product
            $produk = Product::lockForUpdate()->where('id', $request->id_produk)->firstOrFail();
            $meja = $request->meja ? Meja::where('id', $request->meja)->firstOrFail() : null;

            // Jika produk memberlakukan stok, cek dulu dan lakukan decrement atomik
            if ($produk->status_stok === 'on') {
                // untuk sekarang quantity selalu 1, tapi siapkan $qty jika nanti berubah
                $qty = $produk->satuan === 'porsi' ? 1 : 0;

                // cek stok minimal
                if ($qty > 0 && $produk->stok < $qty) {
                    DB::rollBack();
                    return response()->json(['error' => 'Stok produk tidak tersedia. Stok: ' . $produk->stok], 400);
                }

                // lakukan decrement atomik dan periksa apakah berhasil
                // (menghindari race jika belum menggunakan lockForUpdate, plus double safety)
                $affected = Product::where('id', $produk->id)->where('stok', '>=', $qty)->decrement('stok', $qty);

                if ($qty > 0 && $affected === 0) {
                    DB::rollBack();
                    return response()->json(['error' => 'Stok tidak cukup saat mencoba menahan stok.'], 400);
                }
            }

            // Tentukan kuantitas & subtotal
            if ($produk->satuan == 'gram') {
                $kuantitas = 0;
                $sub_total = 0;
            } else {
                $kuantitas = 1;
                $sub_total = $request->sub_total ?? $produk->harga;
            }

            // Cek/buat transaksi
            $mejaId = $meja ? $meja->id : null;
            $transaksi = Transaksi::lockForUpdate()
                ->where('toko_id', Session::get('toko.id'))
                ->where('status', 'keranjang')
                ->where('jenis_transaksi', 'ditempat')
                ->when($mejaId, fn($q) => $q->where('meja_id', $mejaId))
                ->when(!$mejaId, fn($q) => $q->whereNull('meja_id'))
                ->first();

            if (!$transaksi) {
                $transaksi = Transaksi::create([
                    'kode_transaksi' => Str::random(16),
                    'toko_id' => Session::get('toko.id'),
                    'meja_id' => $mejaId,
                    'kuantitas' => 1,
                    'status' => 'keranjang',
                    'jenis_transaksi' => 'ditempat',
                ]);
            } else {
                $transaksi->increment('kuantitas');
            }

            // Cek existing detail (hanya untuk porsi)
            if ($produk->satuan == 'porsi') {
                $existing_detail = TransaksiProduct::where('kode_transaksi', $transaksi->kode_transaksi)->where('produk_id', $request->id_produk)->first();

                if ($existing_detail) {
                    $existing_detail->increment('kuantitas');
                    $existing_detail->update([
                        'subtotal' => $existing_detail->kuantitas * $produk->harga,
                    ]);

                    // setelah decrement sebelumnya (jika status_stok on), refresh produk untuk stok akurat
                    $produk->refresh();

                    DB::commit();

                    return response()->json(
                        [
                            'message' => 'Kuantitas produk berhasil ditambah',
                            'produk' => $produk->nama,
                            'kuantitas' => $existing_detail->kuantitas,
                            'stok_tersisa' => $produk->stok,
                            'updated' => true,
                        ],
                        200,
                    );
                }
            }

            // Buat detail baru via relasi
            $data = [
                'produk_id' => $request->id_produk,
                'kuantitas' => $kuantitas,
                'subtotal' => $sub_total,
            ];

            $detail = $transaksi->produkPivot()->create($data);

            // refresh produk agar stok yang dikembalikan akurat
            $produk->refresh();

            DB::commit();

            return response()->json(
                [
                    'message' => 'Produk berhasil ditambahkan ke keranjang',
                    'produk' => $produk->nama,
                    'satuan' => $produk->satuan,
                    'kuantitas' => $kuantitas,
                    'stok_tersisa' => $produk->stok,
                    'detail_id' => $detail->id,
                    'need_gram_input' => $produk->satuan == 'gram',
                ],
                200,
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('postTransaksiDetail error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Gagal menambahkan produk: ' . $e->getMessage()], 500);
        }
    }

    public function updateTransaksiDetail(Request $request)
    {
        // Validasi input (saya pertahankan sesuai kode Anda)
        $request->validate([
            'id_detail' => 'required|exists:transaksi_products,id',
            'kuan' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Ambil data dengan locking untuk mencegah race condition
            $detail = TransaksiProduct::lockForUpdate()->findOrFail($request->id_detail);

            $produk = $detail->produk()->lockForUpdate()->first();

            if (!$produk) {
                DB::rollBack();
                return response()->json(['error' => 'Produk tidak ditemukan'], 404);
            }

            $harga = $produk->harga;
            $kuantitas_baru = 0;

            // ========== HANDLE PRODUK PER PORSI (+ / -) ==========
            if ($request->qty == 'plus') {
                // Hanya cek dan kurangi stok jika produk memberlakukan stok
                if ($produk->status_stok === 'on') {
                    $affected = Product::where('id', $produk->id)->where('stok', '>=', 1)->decrement('stok', 1);

                    if ($affected === 0) {
                        DB::rollBack();
                        return response()->json(
                            [
                                'error' => 'Stok tidak mencukupi. Stok tersedia: ' . $produk->stok,
                            ],
                            400,
                        );
                    }

                    // sinkron nilai stok di model
                    $produk->refresh();
                }

                $kuantitas_baru = $detail->kuantitas + 1;

                // jika produk tidak memberlakukan stok (status_stok != 'on'), tidak ada perubahan stok
            } elseif ($request->qty == 'minus') {
                if ($detail->kuantitas <= 1) {
                    // Kembalikan stok produk sebanyak kuantitas yang akan dihapus hanya jika diberlakukan stok
                    if ($produk->status_stok === 'on') {
                        Product::where('id', $produk->id)->increment('stok', $detail->kuantitas);
                        $produk->refresh();
                    }

                    // Hapus detail
                    $detail->delete();

                    DB::commit();
                    return response()->json(
                        [
                            'message' => 'Item berhasil dihapus dari transaksi',
                            'deleted' => true,
                        ],
                        200,
                    );
                } else {
                    $kuantitas_baru = $detail->kuantitas - 1;

                    // Kembalikan 1 stok produk jika status_stok 'on'
                    if ($produk->status_stok === 'on') {
                        Product::where('id', $produk->id)->increment('stok', 1);
                        $produk->refresh();
                    }
                }

                // ========== HANDLE PRODUK PER GRAM (INPUT MANUAL) ==========
            } elseif ($request->kuan !== null) {
                $kuantitas_baru = $request->kuan;

                // Validasi: gram harus > 0
                if ($kuantitas_baru <= 0) {
                    DB::rollBack();
                    return response()->json(['error' => 'Jumlah gram harus lebih dari 0'], 400);
                }

                // Jika sebelumnya belum ada kuantitas (baru pertama input)
                if ($detail->kuantitas == 0) {
                    // Hanya cek kurangi 1 stok jika produk memberlakukan stok
                    if ($produk->status_stok === 'on') {
                        $affected = Product::where('id', $produk->id)->where('stok', '>=', 1)->decrement('stok', 1);

                        if ($affected === 0) {
                            DB::rollBack();
                            return response()->json(
                                [
                                    'error' => 'Stok produk habis',
                                ],
                                400,
                            );
                        }

                        $produk->refresh();
                    }
                }
                // Jika sudah ada kuantitas sebelumnya, stok sudah dikurangi saat pertama input => tidak ubah stok
            } else {
                DB::rollBack();
                return response()->json(['error' => 'Parameter tidak valid'], 400);
            }

            // Update detail transaksi
            $detail->update([
                'kuantitas' => $kuantitas_baru,
                'subtotal' => $kuantitas_baru * $harga,
            ]);

            // Pastikan stok di model ter-refresh sebelum dikembalikan
            $produk->refresh();

            DB::commit();

            // Response
            $data = [
                'qty' => $kuantitas_baru,
                'sub_total' => $kuantitas_baru * $harga,
                'stok_tersisa' => $produk->stok,
                'message' => 'Transaksi berhasil diupdate',
            ];

            return response()->json($data, 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(
                [
                    'error' => 'Gagal update transaksi: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function getMeja()
    {
        $data['meja'] = Meja::where('toko_id', Session::get('toko.id'))->get();
        $data['aktif'] = $this->_getActiveMeja();
        return view('pos.respons.meja', $data);
    }

    private function _getActiveMeja()
    {
        $tokoId = Session::get('toko.id');
        // Ambil transaksi status keranjang
        $keranjang = Transaksi::where('toko_id', $tokoId)
            ->where('status', 'keranjang')
            ->get(['meja_id', 'jenis_transaksi']);

        // Ambil transaksi jenis pesanan, status bukan keranjang/batal/selesai
        $pesanan = Transaksi::where('toko_id', $tokoId)
            ->where('jenis_transaksi', 'pesanan')
            ->whereNotIn('status', ['keranjang', 'batal', 'selesai'])
            ->get(['meja_id', 'jenis_transaksi']);

        // Gabungkan collection
        $all = $keranjang->concat($pesanan);

        // Jika kosong, return array kosong
        if ($all->isEmpty()) {
            return [];
        }

        // Group by meja_id, ambil jenis_transaksi pertama
        return $all->groupBy('meja_id')->map(fn($item) => $item->first()->jenis_transaksi)->toArray();
    }

    public function getPesanan()
    {
        $data['pesanan'] = Transaksi::where('toko_id', Session::get('toko.id'))->where('status', 'pending')->orderBy('created_at', 'desc')->get();

        return view('pos.respons.pesanan', $data);
    }

    public function getSubTotal(Request $request)
    {
        $meja = $request->meja;

        $transaksi = Transaksi::where('toko_id', Session::get('toko.id'))
            ->when($request->transaksi != '', fn($q) => $q->where('id', $request->transaksi))
            ->when($request->transaksi == '' && !empty($meja), fn($q) => $q->where('status', 'keranjang')->where('jenis_transaksi', 'ditempat')->where('meja_id', $meja))
            ->when($request->transaksi == '' && empty($meja), fn($q) => $q->where('status', 'keranjang')->where('jenis_transaksi', 'ditempat')->whereNull('meja_id'))
            ->first();

        if (!$transaksi) {
            return response()->json([
                'total' => 'Rp. 0',
                'count' => 0,
            ]);
        }

        $total = $transaksi->produkPivot()->sum('subtotal');
        $count = $transaksi->produkPivot()->count('*');

        $transaksi->update([
            'total_harga' => $total,
        ]);

        return response()->json([
            'total' => 'Rp. ' . number_format($total, 0, ',', '.'),
            'count' => $count,
            'data' => $transaksi,
        ]);
    }

    // public function postTransaksi(Request $request)
    // {
    //     $nama = $request->nama;
    //     $meja = $request->meja;
    //     $bayar = $request->bayar;
    //     $kembali = $request->kembali;
    //     $status = $request->status;

    //     $transaksi = Transaksi::where('toko_id', Session::get('toko.id'))
    //         ->when($request->transaksi != '', fn($q) => $q->where('id', $request->transaksi))
    //         ->when($request->transaksi == '' && !empty($meja), fn($q) => $q->where('status', 'keranjang')->where('jenis_transaksi', 'ditempat')->where('meja_id', $meja))
    //         ->when($request->transaksi == '' && empty($meja), fn($q) => $q->where('status', 'keranjang')->where('jenis_transaksi', 'ditempat')->whereNull('meja_id'))
    //         ->first();

    //     if ($transaksi->jenis_transaksi == 'pesanan') {
    //         $transaksi->update([
    //             'kasir_id' => Auth::user()->id,
    //             'status' => $status,
    //         ]);
    //     } else {
    //         $updateData = [
    //             'kasir_id' => Auth::user()->id,
    //             'nama_pelanggan' => $nama,
    //             'status' => $status,
    //         ];

    //         // Only update payment fields for completed transactions
    //         if ($status == 'selesai') {
    //             $updateData['subtotal'] = $request->total_tagihan;
    //             $updateData['bayar'] = $bayar;
    //             $updateData['kembali'] = $kembali;
    //         }

    //         $transaksi->update($updateData);
    //     }

    //     return response()->json(['transaksi' => $transaksi]);
    // }

    public function postTransaksi(Request $request)
    {
        // Debug: Log request data untuk pengecekan dari console browser
        // Log::info('postTransaksi request data:', $request->all());

        // Validate request data
        $validationRules = [
            'nama' => 'nullable|string|max:255',
            'bayar' => 'required|numeric|min:0',
            'total_tagihan' => 'required|numeric|min:0',
            'status' => 'required|in:pending,selesai',
        ];

        // For completed transactions, payment must be greater than 0
        if ($request->status == 'selesai') {
            $validationRules['bayar'] = 'required|numeric|min:1';
        }

        $request->validate($validationRules);

        $nama = $request->nama;
        $meja = $request->meja;
        $bayar = $request->bayar;
        $kembali = $request->kembali;
        $status = $request->status;

        // ✅ Query yang diperbaiki
        $transaksi = Transaksi::where('toko_id', Session::get('toko.id'))
            ->when(
                $request->transaksi != '',
                function ($q) use ($request) {
                    // Jika ada ID transaksi, gunakan itu
                    $q->where('id', $request->transaksi);
                },
                function ($q) use ($request, $meja) {
                    // Jika tidak ada ID transaksi, cari berdasarkan meja (untuk backward compatibility)
                    $q->where('status', 'keranjang')
                        ->where('jenis_transaksi', 'ditempat')
                        ->when(!empty($meja), fn($query) => $query->where('meja_id', $meja));
                },
            )
            ->first();

        // ✅ Pengecekan null SEBELUM akses property
        if (!$transaksi) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Transaksi tidak ditemukan. Silakan refresh halaman.',
                ],
                404,
            );
        }

        // Additional validation for completed transactions
        if ($status == 'selesai') {
            if ($bayar < $request->total_tagihan) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Nominal pembayaran kurang dari total tagihan.',
                    ],
                    400,
                );
            }
        }

        // ✅ Sekarang aman untuk cek jenis_transaksi
        if ($transaksi->jenis_transaksi == 'pesanan') {
            $transaksi->update([
                'kasir_id' => Auth::user()->id,
                'status' => $status,
            ]);
        } else {
            $transaksi->update([
                'kasir_id' => Auth::user()->id,
                'nama_pelanggan' => $nama,
                'total_harga' => $request->total_tagihan,
                'subtotal' => $request->total_tagihan,
                'bayar' => $bayar,
                'kembali' => $kembali,
                'status' => $status,
            ]);
        }

        return response()->json([
            'success' => true,
            'transaksi' => $transaksi,
        ]);
    }

    public function printTransaksi($transaksi)
    {
        $data['print'] = Transaksi::with('produkPivot.produk')->where('id', $transaksi)->first();
        return view('pos.respons.print', $data);
    }

    public function downloadPdfTransaksi($transaksi)
    {
        // Find transaction and verify it belongs to current user's store
        $data['print'] = Transaksi::with('produkPivot.produk', 'kasir')
            ->where('id', $transaksi)
            ->where('toko_id', Session::get('toko.id'))
            ->firstOrFail();
        
        // Generate PDF using DomPDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pos.respons.print-pdf', $data);
        
        // Set paper size to thermal printer (80mm width)
        $pdf->setPaper([0, 0, 226.77, 841.89], 'portrait'); // 80mm x 297mm in points
        
        $filename = 'struk_' . $data['print']->kode_transaksi . '.pdf';
        
        return $pdf->download($filename);
    }

    public function deleteItem(Request $request)
    {
        // Validasi input
        $request->validate([
            'id' => 'required|exists:transaksi_products,id',
        ]);

        DB::beginTransaction();
        try {
            // Ambil detail dengan locking
            $detail = TransaksiProduct::lockForUpdate()->where('id', $request->id)->firstOrFail();

            // Ambil transaksi
            $transaksi = Transaksi::lockForUpdate()->where('kode_transaksi', $detail->kode_transaksi)->firstOrFail();

            // Ambil produk untuk kembalikan stok
            $produk = Product::lockForUpdate()->where('id', $detail->produk_id)->firstOrFail();

            // ========== KEMBALIKAN STOK PRODUK ==========
            if ($produk->satuan == 'porsi') {
                // Produk PORSI: kembalikan stok sebanyak kuantitas
                $produk->increment('stok', $detail->kuantitas);
            } elseif ($produk->satuan == 'gram') {
                // Produk GRAM: kembalikan 1 stok (karena sudah dikurangi 1 saat ditambahkan)
                // Meskipun ada beberapa baris produk yang sama, setiap baris sudah mengurangi 1 stok
                $produk->increment('stok', 1);
            }

            // ========== UPDATE KUANTITAS TRANSAKSI ==========
            // Kurangi kuantitas di transaksi (jumlah item, bukan jumlah porsi/gram)
            $transaksi->decrement('kuantitas');

            // ========== HAPUS DETAIL ==========
            $detail->delete();

            // ========== CEK APAKAH TRANSAKSI MASIH PUNYA DETAIL ==========
            $sisa_detail = TransaksiProduct::where('kode_transaksi', $transaksi->kode_transaksi)->count();

            if ($sisa_detail == 0) {
                // Jika tidak ada detail lagi, hapus transaksi
                $transaksi->delete();

                DB::commit();

                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Item berhasil dihapus. Keranjang kosong, transaksi dihapus.',
                        'cart_empty' => true,
                    ],
                    200,
                );
            }

            DB::commit();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Item berhasil dihapus dari keranjang',
                    'stok_dikembalikan' => $produk->satuan == 'porsi' ? $detail->kuantitas : 1,
                    'stok_tersisa' => $produk->stok,
                ],
                200,
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(
                [
                    'error' => 'Data tidak ditemukan',
                ],
                404,
            );
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(
                [
                    'error' => 'Gagal menghapus item: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }
}
