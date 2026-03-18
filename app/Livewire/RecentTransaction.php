<?php

namespace App\Livewire;

use App\Models\Kas;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use stdClass;

class RecentTransaction extends Component
{
    use WithPagination;

    public $search = '';
    public $tanggal;
    public $status = 'selesai';
    public $detail;

    // kas
    public $jenis = '';
    public $jumlah = 0;
    public $keterangan = '';
    public $cash;
    public $namaKas;
    public $cantPrint = false;

    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['search'];

    public function mount()
    {
        $this->tanggal = today()->format('Y-m-d');
    }

    public function render()
    {
        $tokoId = session('toko.id');
        $kasirId = Auth::id();

        $baseQuery = Transaksi::with('produkPivot.produk')
            ->where('toko_id', $tokoId)
            ->where('kasir_id', $kasirId)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('kode_transaksi', 'like', "%{$this->search}%")->orWhere('nama_pelanggan', 'like', "%{$this->search}%");
                });
            })
            ->when($this->tanggal, function ($query) {
                $query->whereDate('created_at', $this->tanggal);
            })
            ->when($this->status === 'selesai', fn($query) => $query->whereIn('status', ['selesai', 'menanti']), fn($query) => $query->where('status', $this->status));

        // Pagination
        $transactions = (clone $baseQuery)->latest()->paginate(10);

        // Collection untuk statistik & validasi
        $stats = (clone $baseQuery)->get();

        // Total tunai
        $totalCashTunai = (clone $baseQuery)->where('metode_pembayaran', 'tunai')->sum('subtotal');

        // Total pengeluaran kas selesai
        $totalKas = Kas::where('toko_id', $tokoId)
            ->where('kasir_id', $kasirId)
            ->where('jenis', 'pengeluaran')
            ->where('status', 'selesai')
            ->when($this->tanggal, function ($query) {
                $query->whereDate('created_at', $this->tanggal);
            })
            ->sum('jumlah');

        $this->cash = $totalCashTunai - $totalKas;

        // Ambil data kas untuk validasi
        $kas = Kas::where('toko_id', $tokoId)
            ->where('kasir_id', $kasirId)
            ->when($this->tanggal, function ($query) {
                $query->whereDate('created_at', $this->tanggal);
            })
            ->get();

        /*
    |--------------------------------------------------------------------------
    | VALIDASI PRINT
    |--------------------------------------------------------------------------
    | Print hanya boleh jika:
    | - ADA transaksi
    | - TIDAK ADA status 'menanti'
    | - TIDAK ADA kas status 'diajukan'
    */

        $hasTransaction = $stats->isNotEmpty();
        $hasPendingTransaction = $stats->where('status', 'menanti')->isNotEmpty();
        $hasPendingKas = $kas->where('status', 'diajukan')->isNotEmpty();

        $this->cantPrint = !$hasTransaction || $hasPendingTransaction || $hasPendingKas;

        return view('livewire.rc-transaction', compact('transactions', 'stats', 'kas'));
    }

    public function viewTransaction($transactionId)
    {
        $this->detail = Transaksi::with('produkPivot.produk')->where('kode_transaksi', $transactionId)->first();
        if (!$this->detail) {
            $this->dispatch('error', message: 'Transaksi tidak ditemukan.');
            return;
        }
        $this->dispatch('showTransactionDetail');
        $this->dispatch('openReceipt', transaksiId: $this->detail->id);
    }

    public function cancelTransaction($transactionId)
    {
        $transaction = Transaksi::where('kode_transaksi', $transactionId)->first();
        if (!$transaction) {
            $this->dispatch('error', message: 'Transaksi tidak ditemukan.');
            return;
        }

        if ($transaction->status === 'menanti') {
            $this->dispatch('error', message: 'Transaksi sudah diajukan untuk dibatalkan.');
            return;
        }

        $transaction->status = 'menanti';
        $transaction->save();

        $this->dispatch('success', message: 'Transaksi berhasil diajukan untuk dibatalkan.');
    }

    public function saveKas()
    {
        $this->validate([
            'jenis' => 'required|in:masuk,keluar',
            'jumlah' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string',
        ]);

        $token = Str::random(8);

        Kas::create([
            'token_kas' => $token,
            'toko_id' => session('toko.id'),
            'kasir_id' => Auth::user()->id,
            'nama' => $this->namaKas,
            'jenis' => $this->jenis === 'masuk' ? 'pemasukan' : 'pengeluaran',
            'jumlah' => $this->jumlah,
            'status' => 'diajukan',
            'keterangan' => $this->keterangan,
        ]);

        $this->dispatch('success', message: 'Transaksi kas berhasil diajukan.');
        $this->reset(['jenis', 'jumlah', 'keterangan', 'namaKas']);
    }

    public function termalPrint()
    {
        $tokoId = session('toko.id');
        $kasirId = Auth::id();

        $this->dispatch('openRekap', tanggal: $this->tanggal, tokoId: $tokoId, kasirId: $kasirId);
    }
}
