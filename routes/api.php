<?php

use Illuminate\Support\Facades\Route;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| ANDROID THERMAL PRINTER ROUTE
|--------------------------------------------------------------------------
| Dipanggil oleh Bluetooth Print App via:
| my.bluetoothprint.scheme://https://domain.com/api/android/receipt/{id}
|
| PENTING:
| - JANGAN return view
| - JANGAN response()->json()
| - JANGAN echo apa pun selain JSON
| - WAJIB exit;
|
*/

Route::get('/android/receipt/{id}', function ($id) {
    // Tambahkan ini di paling atas untuk melihat error jika ada
    // error_reporting(E_ALL); ini_set('display_errors', 1);

    header('Content-Type: application/json; charset=utf-8');

    $trx = Transaksi::with(['produkPivot.produk.kategori', 'kasir'])->find($id);

    if (!$trx) {
        return response()->json([]);
    }

    $printType = request()->query('type', 'basic');
    $lebarMaks = 48; // Standar 80mm

    $rupiah = function ($amount) {
        return 'Rp. ' . number_format($amount, 0, ',', '.');
    };

    // Fungsi format baris yang lebih stabil
    $formatBaris = function ($kiri, $kanan) use ($lebarMaks) {
        $sisaSpasi = $lebarMaks - strlen($kiri) - strlen($kanan);
        if ($sisaSpasi < 1) {
            // Jika kepanjangan, potong teks kiri agar tetap satu baris (mencegah error karakter 0)
            $kiri = substr($kiri, 0, $lebarMaks - strlen($kanan) - 1);
            $sisaSpasi = 1;
        }
        return $kiri . str_repeat(' ', $sisaSpasi) . $kanan;
    };

    $data = [];

    // 1. OPEN DRAWER (PENTING: Pastikan kolom metode_pembayaran ada di DB)
    if (isset($trx->metode_pembayaran) && strtolower($trx->metode_pembayaran) == 'tunai') {
        $data[] = ['type' => 0, 'content' => chr(27) . chr(112) . chr(48) . chr(25) . chr(250)];
    }

    // 2. LOOP STRUK UTAMA
    for ($i=0; $i <= 1; $i++) {
        $data[] = ['type' => 0, 'content' => 'AL KINZA', 'bold' => 1, 'align' => 1, 'format' => 2];
        $data[] = ['type' => 0, 'content' => 'Invoice: '.$trx->kode_transaksi, 'align' => 0];
        $data[] = ['type' => 0, 'content' => 'Tanggal: '.$trx->created_at->format('d M Y H:i'), 'align' => 0];
        $data[] = ['type' => 0, 'content' => 'Kasir: '.$trx->kasir->name, 'align' => 0];
        if ($trx->nama_pelanggan) {
            $data[] = ['type' => 0, 'content' => 'Cus: '.$trx->nama_pelanggan, 'bold' => 1, 'align' => 0];
        }
        $data[] = ['type' => 0, 'content' => '------------------------------------------------', 'align' => 1];

        foreach ($trx->produkPivot as $item) {
            if (!$item->produk) continue;

            $labelKiri = $item->produk->name;
            // Persingkat label kanan agar tidak terlalu panjang
            $labelKanan = $item->kuantitas . 'x' . number_format($item->produk->harga, 0, ',', '.') . '=' . number_format($item->subtotal, 0, ',', '.');

            $data[] = [
                'type'    => 0,
                'content' => $formatBaris($labelKiri, $labelKanan),
                'align'   => 0
            ];
        }

        $data[] = ['type' => 0, 'content' => '------------------------------------------------', 'align' => 1];
        $data[] = ['type' => 0, 'content' => $formatBaris('TOTAL', $rupiah($trx->subtotal)), 'bold' => 1];
        $data[] = ['type' => 0, 'content' => $formatBaris('BAYAR', $rupiah($trx->bayar))];
        $data[] = ['type' => 0, 'content' => $formatBaris('KEMBALI', $rupiah($trx->kembali))];
        $data[] = ['type' => 0, 'content' => '------------------------------------------------', 'align' => 1];
        $data[] = ['type' => 0, 'content' => 'TERIMA KASIH', 'align' => 1];

        // CUTTING
        // CUTTING: Skip cutting code on last loop if printType is 'basic'
        if ($printType == 'basic' && $i == 1) {
            $data[] = ['type' => 0, 'content' => "\n\n\n\n"];
        } else {
            $data[] = ['type' => 0, 'content' => "\n\n\n\n" . chr(29) . chr(86) . chr(66) . chr(0)];
        }
    }

    // 3. KITCHEN & BAR RECEIPTS (jika printType != 'basic')
    if ($printType != 'basic') {
        // Filter items by category
        $itemDapur = $trx->produkPivot->filter(function($item) {
            return $item->produk && strtolower($item->produk->kategori->name) !== 'minuman';
        });

        $itemMinuman = $trx->produkPivot->filter(function($item) {
            return $item->produk && strtolower($item->produk->kategori->name) === 'minuman';
        });

        // Kitchen Receipt
        if ($itemDapur->count() > 0) {
            $data[] = ['type' => 0, 'content' => '*** PESANAN DAPUR ***', 'bold' => 1, 'align' => 1, 'format' => 3];
            $data[] = ['type' => 0, 'content' => 'Tgl: '.$trx->created_at->format('d/m/y H:i'), 'align' => 1];
            $data[] = ['type' => 0, 'content' => 'Kasir: '.$trx->kasir->name, 'align' => 1];

            if ($trx->nama_pelanggan) {
                $data[] = ['type' => 0, 'content' => 'Cust: '.$trx->nama_pelanggan, 'bold' => 1, 'align' => 1];
            }

            $data[] = ['type' => 0, 'content' => '------------------------------', 'align' => 1];

            foreach ($itemDapur as $item) {
                $data[] = ['type' => 0, 'content' => $item->produk->name . ' x' . $item->kuantitas, 'bold' => 1, 'align' => 0];
            }

            $data[] = ['type' => 0, 'content' => "\n\n\n\n" . chr(29) . chr(86) . chr(66) . chr(0)];
        }

        // Bar/Beverage Receipt
        if ($itemMinuman->count() > 0) {
            $data[] = ['type' => 0, 'content' => '*** PESANAN MINUMAN ***', 'bold' => 1, 'align' => 1, 'format' => 3];
            $data[] = ['type' => 0, 'content' => 'Tgl: '.$trx->created_at->format('d/m/y H:i'), 'align' => 1];
            $data[] = ['type' => 0, 'content' => 'Kasir: '.$trx->kasir->name, 'align' => 1];

            if ($trx->nama_pelanggan) {
                $data[] = ['type' => 0, 'content' => 'Cust: '.$trx->nama_pelanggan, 'bold' => 1, 'align' => 1];
            }

            $data[] = ['type' => 0, 'content' => '------------------------------', 'align' => 1];

            foreach ($itemMinuman as $item) {
                $data[] = ['type' => 0, 'content' => $item->produk->name . ' x' . $item->kuantitas, 'bold' => 1, 'align' => 0];
            }

            // $data[] = ['type' => 0, 'content' => "\n\n\n\n" . chr(29) . chr(86) . chr(66) . chr(0)];
        }
    }

    // Dan mengabaikan error karakter biner (UTF-8)
    $json = json_encode($data, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_IGNORE);

    return response($json)
        ->header('Content-Type', 'application/json; charset=utf-8');
});

Route::get('/android/rekap/{tanggal}/{tokoId}/{kasirId}', function ($tanggal, $tokoId, $kasirId) {
    header('Content-Type: application/json; charset=utf-8');

    // $tokoId = session('toko.id');
    $kasir = \App\Models\User::where('id', $kasirId)->first();

    $transaksi = \App\Models\Transaksi::whereDate('created_at', $tanggal)
        ->where('toko_id', $tokoId)
        ->where('kasir_id', $kasirId)
        ->whereIn('status', ['selesai', 'menanti'])
        ->get();

    $kasKeluar = \App\Models\Kas::whereDate('created_at', $tanggal)->where('toko_id', $tokoId)->where('kasir_id', $kasirId)->where('jenis', 'pengeluaran')->where('status', 'selesai')->get();

    if (!$transaksi) {
        echo '{}';
        exit();
    }

    $rupiah = fn($a) => 'Rp. ' . number_format($a, 0, ',', '.');

    $totalTransaksi = $transaksi->count();
    $totalItem = $transaksi->sum(function ($trx) {
        return $trx->produkPivot
            ->whereIn('satuan', ['pcs', 'porsi'])
            ->sum('kuantitas') + $trx->produkPivot->where('satuan', 'gram')
            ->count();
    });
    $grandTotal = $transaksi->sum('subtotal');
    $totalTunai = $transaksi->where('metode_pembayaran', 'tunai')->sum('subtotal');
    $totalNonTunai = $transaksi->where('metode_pembayaran', '!=', 'tunai')->sum('subtotal');
    $totalPengeluaran = $kasKeluar->sum('jumlah');

    $data = [];

    /* ================= HEADER ================= */

    $data[] = [
        'type' => 0,
        'content' => 'AL KINZA',
        'bold' => 1,
        'align' => 1,
        'format' => 2,
    ];

    $data[] = ['type' => 0, 'content' => '============================', 'align' => 1];

    $data[] = ['type' => 0, 'content' => "Tanggal : {$tanggal}", 'align' => 0];
    $data[] = ['type' => 0, 'content' => 'Kasir   : ' . $kasir->name, 'align' => 0];
    $data[] = ['type' => 0, 'content' => "Total Trx : {$totalTransaksi}", 'align' => 0];
    $data[] = ['type' => 0, 'content' => "Total Item: {$totalItem}", 'align' => 0];

    $data[] = ['type' => 0, 'content' => '============================', 'align' => 1];

    $data[] = ['type' => 0, 'content' => 'Grand Total   : ' . $rupiah($grandTotal), 'align' => 2];
    $data[] = ['type' => 0, 'content' => 'Tunai         : ' . $rupiah($totalTunai), 'align' => 2];
    $data[] = ['type' => 0, 'content' => 'Non Tunai     : ' . $rupiah($totalNonTunai), 'align' => 2];
    $data[] = ['type' => 0, 'content' => 'Pengeluaran   : ' . $rupiah($totalPengeluaran), 'align' => 2];

    $data[] = ['type' => 0, 'content' => '============================', 'align' => 1];

    /* ================= DETAIL PENGELUARAN ================= */
    $data[] = ['type' => 0, 'content' => 'DETAIL PENGELUARAN', 'align' => 1];

    foreach ($kasKeluar as $item) {
        $data[] = [
            'type' => 0,
            'content' => $item->nama . ' = ' . $rupiah($item->jumlah),
            'align' => 0,
        ];
    }

    $data[] = ['type' => 0, 'content' => '============================', 'align' => 1];
    $data[] = ['type' => 0, 'content' => 'Total Cash: ' . $rupiah($totalTunai - $totalPengeluaran), 'align' => 0];
    $data[] = ['type' => 0, 'content' => '============================', 'align' => 1];
    $data[] = ['type' => 0, 'content' => ' ', 'align' => 1];
    $data[] = ['type' => 0, 'content' => 'Shift Closed', 'align' => 1];
    $data[] = ['type' => 0, 'content' => ' ', 'align' => 1];

    echo json_encode($data, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
    exit();
});
