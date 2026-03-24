<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kas;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class KasController extends Controller
{
    public function index()
    {
        $tokoId = Session::get('toko.id');

        $pemasukan = Kas::where('toko_id', $tokoId)->where('jenis', 'pemasukan')->sum('jumlah');
        $pengeluaran = Kas::where('toko_id', $tokoId)->where('jenis', 'pengeluaran')->sum('jumlah');

        $data = [
            'kas' => Kas::where('toko_id', $tokoId)->latest()->get(),
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'saldo' => $pemasukan - $pengeluaran,
        ];

        return view('admin.kas.kas-index', $data);
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nama_kas' => 'required|string|max:100',
                'jenis_kas' => 'required|in:pemasukan,pengeluaran',
                'nominal_kas' => 'required|numeric|min:0',
                'keterangan' => 'nullable|string',
            ],
            [
                'nama_kas.required' => 'Nama kas harus diisi.',
                'jenis_kas.required' => 'Jenis kas harus dipilih.',
                'jenis_kas.in' => 'Jenis kas harus berupa pemasukan atau pengeluaran.',
                'nominal_kas.required' => 'Nominal kas harus diisi.',
                'nominal_kas.numeric' => 'Nominal kas harus berupa angka.',
                'nominal_kas.min' => 'Nominal kas tidak boleh kurang dari 0.',
            ],
        );

        Kas::create([
            'token_kas' => Str::random(8),
            'toko_id' => Session::get('toko.id'),
            'nama' => $request->nama_kas,
            'jenis' => $request->jenis_kas,
            'jumlah' => $request->nominal_kas,
            'keterangan' => $request->keterangan,
            'tanggal' => now(),
        ]);
        return redirect()->route('kas.index')->with('success', 'Data kas berhasil ditambahkan.');
    }

    public function update(Request $request, Kas $ka)
    {
        $request->validate(
            [
                'nama_kas' => 'required|string|max:100',
                'jenis_kas' => 'required|in:pemasukan,pengeluaran',
                'nominal_kas' => 'required|numeric|min:0',
                'keterangan' => 'nullable|string',
            ],
            [
                'nama_kas.required' => 'Nama kas harus diisi.',
                'jenis_kas.required' => 'Jenis kas harus dipilih.',
                'jenis_kas.in' => 'Jenis kas harus berupa pemasukan atau pengeluaran.',
                'nominal_kas.required' => 'Nominal kas harus diisi.',
                'nominal_kas.numeric' => 'Nominal kas harus berupa angka.',
                'nominal_kas.min' => 'Nominal kas tidak boleh kurang dari 0.',
            ],
        );

        $ka->update([
            'nama' => $request->nama_kas,
            'jenis' => $request->jenis_kas,
            'jumlah' => $request->nominal_kas,
            'keterangan' => $request->keterangan,
        ]);
        return redirect()->route('kas.index')->with('success', 'Data kas berhasil diperbarui.');
    }

    public function destroy(Kas $ka)
    {
        $ka->delete();
        return redirect()->route('kas.index')->with('success', 'Data kas berhasil dihapus.');
    }

    public function laporan_transaksi(Request $request)
    {
        $tokoId = Session::get('toko.id');
        $searchDate = $request->input('searchDate') ? date('Y-m-d', strtotime($request->input('searchDate'))) : now()->format('Y-m-d');
        $searchKasir = $request->input('searchKasir');
        $kasir = User::whereHas('tokos', function ($q) use ($tokoId) {
            return $q->where('toko_id', $tokoId);
        })
            ->role('kasir')
            ->get();

        $transaksi = Transaksi::with(['produkPivot.produk', 'produkPivot.items'])
            ->where('toko_id', $tokoId)
            ->when($searchDate, function ($query, $searchDate) {
                return $query->whereDate('created_at', $searchDate);
            })
            ->when($searchKasir, function ($query, $searchKasir) {
                return $query->where('kasir_id', $searchKasir);
            })
            ->whereIn('status', ['selesai', 'menanti', 'pending', 'keranjang'])
            ->latest()
            ->get();

        return view('admin.transaksi.laporan-transaksi', compact('transaksi', 'kasir'));
    }

    public function update_pembatalan(Request $request, $id)
    {
        $action = $request->input('action');
        $transaksi = Transaksi::find($id);

        // dd($action, $transaksi);

        if (!$transaksi) {
            return redirect()->route('laporan.transaksi')->with('error', 'Transaksi tidak ditemukan.');
        }

        if ($action === 'accept') {
            $transaksi->produkPivot()->delete();
            $transaksi->delete();
            return redirect()->route('laporan.transaksi')->with('success', 'Transaksi berhasil dibatalkan.');
        } elseif ($action === 'reject') {
            $transaksi->status = 'selesai';
            $transaksi->save();
            return redirect()->route('laporan.transaksi')->with('success', 'Pembatalan transaksi berhasil ditolak.');
        } else {
            return redirect()->route('laporan.transaksi')->with('error', 'Aksi tidak valid.');
        }
    }

    public function laporan_shift(Request $request)
    {
        $searchKasir = $request->input('kasir');
        $tokoId = Session::get('toko.id');
        $kasir = User::whereHas('tokos', function ($q) use ($tokoId) {
            return $q->where('toko_id', $tokoId);
        })
            ->role('kasir')
            ->get();

        $transaksi = Transaksi::select(DB::raw('DATE(created_at) as tanggal'), 'kasir_id', DB::raw('SUM(subtotal) as total'), DB::raw('SUM(CASE WHEN metode_pembayaran = "tunai" THEN subtotal ELSE 0 END) as tunai'), DB::raw('SUM(CASE WHEN metode_pembayaran = "non-tunai" THEN subtotal ELSE 0 END) as non_tunai'))
            ->where('toko_id', $tokoId)
            ->where('status', 'selesai')
            ->when($searchKasir, function ($query, $searchKasir) {
                return $query->where('kasir_id', $searchKasir);
            })
            ->groupBy(DB::raw('DATE(created_at)'), 'kasir_id')
            ->orderBy('tanggal', 'desc')
            ->get();

        $laporan = [];

        foreach ($transaksi as $row) {
            if (!isset($laporan[$row->tanggal])) {
                $laporan[$row->tanggal] = [
                    'kasir' => [],
                    'tunai' => 0,
                    'non_tunai' => 0,
                ];
            }

            $laporan[$row->tanggal]['kasir'][$row->kasir_id] = [
                'total' => $row->total,
                'tunai' => $row->tunai,
                'non_tunai' => $row->non_tunai,
            ];

            $laporan[$row->tanggal]['tunai'] += $row->tunai;
            $laporan[$row->tanggal]['non_tunai'] += $row->non_tunai;
        }

        return view('admin.transaksi.laporan-shift', compact('laporan', 'kasir'));
    }

    public function approve($token_kas)
    {
        $kas = Kas::where('token_kas', $token_kas)->firstOrFail();
        $kas->status = 'selesai';
        $kas->save();

        return redirect()->route('kas.index')->with('success', 'Kas berhasil disetujui.');
    }

    public function reject($token_kas)
    {
        $kas = Kas::where('token_kas', $token_kas)->firstOrFail();
        $kas->status = 'ditolak';
        $kas->save();

        return redirect()->route('kas.index')->with('success', 'Kas berhasil ditolak.');
    }
}
