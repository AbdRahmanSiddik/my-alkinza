<?php

namespace App\Livewire;

use App\Models\Kategori;
use App\Models\Product;
use App\Models\Transaksi;
use App\Models\TransaksiProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;

use function PHPSTORM_META\type;

class Pos extends Component
{
    public $search = '';
    public $searchPending = '';
    public $customerName;
    public $activeCategory = 'all';
    public $cash = 0;
    public $keranjang;
    public $cartProductIds = [];
    public $gramasi = [];
    public $paymentMethod = 'tunai';
    public $print;

    protected $queryString = ['search'];
    protected $listeners = ['setCategory'];

    public function updatedPaymentMethod($value)
    {
        if ($value === 'non-tunai') {
            $this->cash = $this->totalPayable; // atau subtotal sesuai logic lu
        }
    }

    public function setCategory($token)
    {
        $this->activeCategory = $token;
    }

    public function getSubtotalProperty()
    {
        if (!$this->keranjang || $this->keranjang->produkPivot->isEmpty()) {
            return 0;
        }

        return $this->keranjang->produkPivot->sum('subtotal');
    }

    public function getTotalPayableProperty()
    {
        return $this->subtotal;
    }

    public function getKembalianProperty()
    {
        if ($this->paymentMethod === 'non-tunai') {
            return 0;
        }

        return max(0, (int) $this->cash - (int) $this->totalPayable);
    }

    public function addToCart($token)
    {
        // $this->search = $token;
        if (!$token) {
            return;
        }
        $produk = Product::where('token_product', $token)->first();
        if (!$produk) {
            return;
        }

        DB::beginTransaction();
        // kurangi stok
        if ($produk->status_stok == 'on') {
            $updated = Product::where('id', $produk->id)->where('stok', '>', 0)->decrement('stok', 1);

            if ($updated === 0) {
                DB::rollBack();
                $this->dispatch('alert', type: 'error', message: 'Stok tidak mencukupi.');
                return;
            }
        }

        // buat transaksi jika belum ada
        if (!$this->keranjang) {
            $this->keranjang = Transaksi::create([
                'kode_transaksi' => Str::upper(Str::random(16)),
                'toko_id' => session('toko.id'),
                'kasir_id' => Auth::id(),
                'status' => 'keranjang',
                'metode_pembayaran' => 'pending',
                'nama_pelanggan' => $this->customerName,
            ]);
        }

        // ===== PCS / PORSI =====
        if (in_array($produk->satuan, ['pcs', 'porsi'])) {
            $exists = $this->keranjang->produkPivot()->where('produk_id', $produk->id)->exists();

            if ($exists) {
                return;
            }

            $this->keranjang->produkPivot()->create([
                'produk_id' => $produk->id,
                'satuan' => $produk->satuan,
                'kuantitas' => 1,
                'subtotal' => $produk->harga,
            ]);
        }

        // ===== GRAM =====
        if ($produk->satuan === 'gram') {
            $this->keranjang->produkPivot()->create([
                'produk_id' => $produk->id,
                'satuan' => 'gram',
                'kuantitas' => 0, // nanti diisi gram
                'subtotal' => 0,
            ]);
        }

        DB::commit();
        $this->dispatch('alert', type: 'success', message: 'Produk ditambahkan ke keranjang.');
        $this->refreshKeranjang();
    }

    public function refreshKeranjang()
    {
        $this->keranjang->refresh();

        $this->cartProductIds = $this->keranjang->produkPivot
            ->whereIn('satuan', ['pcs', 'porsi'])
            ->pluck('produk_id')
            ->toArray();
    }

    public function updatedGramasi($value, $itemId)
    {
        $item = TransaksiProduct::find($itemId);
        $hargaPerGram = $item->produk->harga;

        $item->update([
            'kuantitas' => $value,
            'subtotal' => $value * $hargaPerGram,
        ]);

        $this->refreshKeranjang();
    }

    public function decreaseQty($itemId)
    {
        $item = TransaksiProduct::find($itemId);
        if (!$item) {
            return;
        }

        if ($item->kuantitas <= 1) {
            return;
        }

        if ($item->produk->status_stok == 'on') {
            // kembalikan stok produk
            $item->produk->increment('stok', 1);
        }

        $item->update([
            'kuantitas' => $item->kuantitas - 1,
            'subtotal' => ($item->kuantitas - 1) * $item->produk->harga,
        ]);

        $this->refreshKeranjang();
    }

    public function increaseQty($itemId)
    {
        $item = TransaksiProduct::find($itemId);
        if (!$item) {
            return;
        }

        if ($item->produk->status_stok == 'on') {
            $updated = Product::where('id', $item->produk->id)->where('stok', '>', 0)->decrement('stok', 1);

            if ($updated === 0) {
                $this->dispatch('alert', type: 'error', message: 'Stok tidak mencukupi.');
                return;
            }
        }

        $item->update([
            'kuantitas' => $item->kuantitas + 1,
            'subtotal' => ($item->kuantitas + 1) * $item->produk->harga,
        ]);

        $this->refreshKeranjang();
    }

    public function removeItem($itemId)
    {
        $item = TransaksiProduct::find($itemId);
        if (!$item) {
            return;
        }

        if ($item->produk->status_stok == 'on') {
            // kembalikan stock produk
            if ($item->satuan === 'gram') {
                // untuk satuan gram, kembalikan 1 stok per item (bukan per gram)
                $item->produk->increment('stok', 1);
            } else {
                $item->produk->increment('stok', $item->kuantitas);
            }
        }

        if ($this->keranjang->produkPivot->count() == 1) {
            // jika ini item terakhir, hapus keranjang
            $this->keranjang->delete();
            $this->keranjang = null;
            $this->cartProductIds = [];
            $this->gramasi = [];
            return;
        } else {
            $item->delete();
        }

        $this->refreshKeranjang();
    }

    public function updatedCustomerName($value)
    {
        if ($this->keranjang) {
            $this->keranjang->update([
                'nama_pelanggan' => $value,
            ]);
        }
    }

    public function mount()
    {
        $this->keranjang = Transaksi::with('produkPivot')
            ->where('toko_id', session('toko.id'))
            ->where('kasir_id', Auth::user()->id)
            ->where('status', 'keranjang')
            ->first();
        // Log::info('keranjang: ' . json_encode($this->keranjang));

        $this->cartProductIds = $this->keranjang ? $this->keranjang->produkPivot->pluck('produk_id')->unique()->toArray() : [];

        // Log::info('cartProductIds: ' . json_encode($this->cartProductIds));

        if ($this->keranjang) {
            foreach ($this->keranjang->produkPivot as $item) {
                if ($item->satuan === 'gram') {
                    $this->gramasi[$item->id] = $item->kuantitas;
                }
            }
        }
    }

    public function clearCart()
    {
        if (!$this->keranjang) {
            return;
        }

        DB::beginTransaction();

        // kembalikan stock produk
        foreach ($this->keranjang->produkPivot as $item) {
            if ($item->satuan === 'gram') {
                // untuk satuan gram, kembalikan 1 stok per item (bukan per gram)
                $item->produk->increment('stok', 1);
            } else {
                $item->produk->increment('stok', $item->kuantitas);
            }
        }

        // hapus item di keranjang
        $this->keranjang->produkPivot()->delete();

        // hapus keranjang
        $this->keranjang->delete();
        $this->keranjang = null;
        $this->cartProductIds = [];
        $this->gramasi = [];

        $this->dispatch('alert', type: 'success', message: 'Keranjang dibersihkan.');

        DB::commit();
    }

    public function placeOrder($status = 'selesai')
    {
        if (!$this->keranjang || $this->keranjang->produkPivot->isEmpty()) {
            $this->dispatch('alert', type: 'error', message: 'Keranjang kosong.');
            return;
        }

        if ($status === 'selesai') {
            if ($this->paymentMethod === 'tunai' && ($this->cash == 0 || $this->cash < $this->totalPayable)) {
                $this->dispatch('alert', type: 'error', message: 'Uang tidak cukup.');
                return;
            }
        }

        $kuantitas = $this->keranjang->produkPivot->where('satuan', 'gram')->count() + $this->keranjang->produkPivot->where('satuan', '!=', 'gram')->sum('kuantitas');

        DB::beginTransaction();

        // SIMPAN ID SEBELUM DI RESET
        $transaksiId = $this->keranjang->id;

        $this->keranjang->update([
            'status' => $status,
            'subtotal' => $this->subtotal,
            'bayar' => $this->cash,
            'metode_pembayaran' => $this->paymentMethod,
            'kembali' => $this->kembalian,
            'kuantitas' => $kuantitas,
        ]);

        DB::commit();
        $this->print = Transaksi::with('produkPivot.produk')
        ->find($transaksiId);

        // reset state POS
        $this->keranjang = null;
        $this->cartProductIds = [];
        $this->gramasi = [];
        $this->customerName = '';
        $this->cash = 0;

        $this->dispatch('alert', type: 'success', message: 'Pesanan berhasil diproses.');
        $this->dispatch('openReceipt', transaksiId: $transaksiId);
    }

    public function render()
    {
        $products = Product::with('kategori')
            ->where('toko_id', session('toko.id'))
            ->when($this->activeCategory !== 'all', function ($q) {
                $q->whereHas('kategori', function ($k) {
                    $k->where('token_kategori', $this->activeCategory);
                });
            })
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            })
            ->get();

        $categories = Kategori::where('toko_id', session('toko.id'))->get();

        $pendingTransactions = Transaksi::with('produkPivot')
            ->where('toko_id', session('toko.id'))
            ->where('kasir_id', Auth::user()->id)
            ->where('status', 'pending')
            ->when($this->searchPending, function ($q) {
                $q->where(function ($qq) {
                    $qq->where('kode_transaksi', 'like', '%' . $this->searchPending . '%')->orWhere('nama_pelanggan', 'like', '%' . $this->searchPending . '%');
                });
            })
            ->latest()
            ->get();

        return view('livewire.pos', compact('products', 'categories', 'pendingTransactions'));
    }

    public function closeModal($modalId)
    {
        $this->dispatch('closeModal', modalId: $modalId);
    }

    public function addCash($amount)
    {
        $this->cash += (int) $amount;

        // $this->dispatch('update-cash-input', value: number_format($this->cash, 0, ',', '.'));
    }

    public function clearCash()
    {
        $this->cash = 0;
        // $this->dispatch('update-cash-input', value: '');
    }

    public function updatedCash($value)
    {
        $this->cash = (int) preg_replace('/[^\d]/', '', $value);
    }

    public function restoreTransaction($transaksiId)
    {
        // cek dulu keranjang aktif
        if (!empty($this->keranjang)) {
            $this->dispatch('alert', type: 'error', message: 'Anda masih memiliki transaksi yang belum selesai. Selesaikan atau simpan terlebih dahulu.');
            return;
        }

        try {
            DB::transaction(function () use ($transaksiId) {
                $transaksi = Transaksi::with('produkPivot')
                    ->where('id', $transaksiId)
                    ->where('toko_id', session('toko.id'))
                    ->where('kasir_id', Auth::id())
                    ->lockForUpdate() // 🔒 kunci row biar gak direstore barengan
                    ->first();

                if (!$transaksi) {
                    throw new \Exception('Transaksi tidak ditemukan.');
                }

                // cek ulang status (antisipasi restore tab lain)
                if ($transaksi->status !== 'pending') {
                    throw new \Exception('Transaksi sudah diproses atau sedang digunakan.');
                }

                $transaksi->update([
                    'status' => 'keranjang',
                ]);

                // set keranjang livewire
                $this->keranjang = $transaksi;

                // null safety
                $this->cash = $transaksi->bayar ?? 0;

                // 🔥 ISI ULANG GRAMASI DI SINI
                foreach ($transaksi->produkPivot as $item) {
                    if ($item->produk->satuan === 'gram') {
                        $this->gramasi[$item->id] = $item->kuantitas;
                    }
                }
            });

            $this->dispatch('alert', type: 'success', message: 'Transaksi berhasil di restore.');
        } catch (\Exception $e) {
            $this->dispatch('alert', type: 'error', message: $e->getMessage());
        }
    }

    public function deleteTransaction($transaksiId)
    {
        try {
            DB::transaction(function () use ($transaksiId) {
                $transaksi = Transaksi::with('produkPivot.produk')->where('id', $transaksiId)->where('toko_id', session('toko.id'))->where('kasir_id', Auth::id())->lockForUpdate()->first();

                if (!$transaksi) {
                    throw new \Exception('Transaksi tidak ditemukan.');
                }

                if ($transaksi->status !== 'pending') {
                    throw new \Exception('Hanya transaksi pending yang bisa dibatalkan.');
                }

                // balikin stok
                foreach ($transaksi->produkPivot as $item) {
                    if (!$item->produk) {
                        continue; // safety kalau produk udah dihapus
                    }

                    if ($item->satuan === 'gram') {
                        $item->produk->increment('stok', 1);
                    } else {
                        $item->produk->increment('stok', $item->kuantitas);
                    }
                }

                // hapus pivot
                $transaksi->produkPivot()->delete();

                // hapus transaksi
                $transaksi->delete();
            });

            $this->dispatch('alert', type: 'success', message: 'Transaksi pending berhasil dibatalkan.');
        } catch (\Exception $e) {
            $this->dispatch('alert', type: 'error', message: $e->getMessage());
        }
    }
}
