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

// Route::get('/android/receipt/{id}', function ($id) {
//     header('Content-Type: application/json; charset=utf-8');

//     // Ambil parameter type dari URL (default 'basic')
//     $printType = request()->query('type', 'basic');

//     $trx = Transaksi::with(['produkPivot.produk.kategori', 'kasir'])->find($id);

//     if (!$trx) {
//         echo '{}';
//         exit;
//     }

//     $rupiah = function ($amount) {
//         return 'Rp. ' . number_format($amount, 0, ',', '.');
//     };

//     $data = [];

//     /* ============================================================
//     * LOGIKA BUKA LACI KASIR (Hanya jika Pembayaran Tunai)
//     * ============================================================ */
//     if (strtolower($trx->metode_pembayaran) == 'tunai') {
//         $data[] = [
//             'type'    => 0,
//             'content' => chr(27) . chr(112) . chr(48) . chr(25) . chr(250),
//             'align'   => 0
//         ];
//     }

//     // LOOP UNTUK KASIR & CUSTOMER (2 KALI)
//     for ($i=0; $i <= 1; $i++) {
//         $data[] = [
//             'type'   => 0,
//             'content' => 'AL KINZA',
//             'bold'   => 1,
//             'align'  => 1,
//             'format' => 2
//         ];

//         $data[] = ['type' => 0, 'content'=> ' ', 'align' => 1];
//         $data[] = ['type' => 0, 'content'=> 'Invoice: '.$trx->kode_transaksi, 'align' => 0];
//         $data[] = ['type' => 0, 'content'=> 'Tanggal: '.$trx->created_at->format('d M Y H:i'), 'align' => 0];
//         $data[] = ['type' => 0, 'content'=> 'Kasir: '.$trx->kasir->name, 'align' => 0];
//         $data[] = ['type' => 0, 'content'=> '------------------------------', 'align' => 1];

//         if ($trx->nama_pelanggan != null){
//             $data[] = ['type' => 0, 'content'=> 'Cus: '.$trx->nama_pelanggan, 'align' => 0];
//             $data[] = ['type' => 0, 'content'=> '------------------------------', 'align' => 1];
//         }

//         foreach ($trx->produkPivot as $item) {
//             if (!$item->produk) continue;
//             $data[] = ['type' => 0, 'content'=> $item->produk->name, 'align' => 0];
//             $data[] = [
//                 'type'   => 0,
//                 'content'=> $item->kuantitas.' x '.$rupiah($item->produk->harga).' = '.$rupiah($item->subtotal),
//                 'align'  => 2
//             ];
//         }

//         $data[] = ['type' => 0, 'content'=> '------------------------------', 'align' => 1];
//         $data[] = ['type' => 0, 'content'=> 'TOTAL : '.$rupiah($trx->subtotal), 'bold' => 1, 'align' => 2];
//         $data[] = ['type' => 0, 'content'=> 'BAYAR : '.$rupiah($trx->bayar), 'align' => 2];
//         $data[] = ['type' => 0, 'content'=> 'KEMBALI : '.$rupiah($trx->kembali), 'align' => 2];
//         $data[] = ['type' => 0, 'content' => '------------------------------', 'align' => 1];
//         $data[] = ['type' => 0, 'content'=> 'Note:', 'align' => 0];
//         $data[] = ['type' => 0, 'content'=> ' ', 'align' => 1];
//         $data[] = ['type' => 0, 'content' => '------------------------------', 'align' => 1];
//         $data[] = ['type' => 0, 'content' => 'ALKINZA RESTO: pesanlangsungbayar', 'align' => 1];
//         $data[] = ['type' => 0, 'content' => 'Reservasi: +62-813-7000-419', 'align' => 1];
//         $data[] = ['type' => 0, 'content'=> 'TERIMA KASIH', 'align' => 1];

//         /* * LOGIKA CUTTING UNTUK KASIR/CUST
//          * Jika Print Biasa ($printType == 'basic') DAN ini adalah iterasi terakhir ($i == 1),
//          * JANGAN kasih kode potong (biar printer auto-cut atau manual).
//          */
//         if ($printType == 'basic' && $i == 1) {
//             $data[] = ['type' => 0, 'content' => "\n\n\n\n", 'align' => 0];
//         } else {
//             // Selain kondisi di atas (Print Lengkap atau masih iterasi pertama), kasih kode potong.
//             $data[] = [
//                 'type'    => 0,
//                 'content' => "\n\n\n\n" . chr(29) . chr(86) . chr(66) . chr(0),
//                 'align'   => 0
//             ];
//         }
//     }

//     /* ============================================================
//     * LOGIKA PEMISAHAN KATEGORI (URGENT HARD-CODED)
//     * ============================================================ */

//     // 1. Filter Item Dapur:
//     // Semua yang BUKAN 'minuman' (Termasuk kategori 'Lainnya' dan Produk Paket)
//     $itemDapur = $trx->produkPivot->filter(function($item) {
//         return strtolower($item->produk->kategori->name) !== 'minuman';
//     });

//     // 2. Filter Item Minuman (Hard-coded untuk produk spesifik):
//     $itemMinuman = $trx->produkPivot->filter(function($item) {
//         $kategori = strtolower($item->produk->kategori->name);
//         $namaProduk = strtolower($item->produk->name);

//         // Syarat masuk Bar: Kategori emang minuman, ATAU Nama Produk spesifik di gambar
//         return ($kategori === 'minuman') || ($namaProduk === 'paket 7k nasi + teh');
//     });

//     /* =========================
//     * STRUK DAPUR (MAKANAN)
//     * ========================= */
//     if ($itemDapur->count() > 0) {
//         $data[] = ['type' => 0, 'content' => '*** PESANAN DAPUR ***', 'bold' => 1, 'align' => 1, 'format' => 3];
//         $data[] = ['type' => 0, 'content' => 'Tgl: '.$trx->created_at->format('d/m/y H:i'), 'align' => 1];
//         $data[] = ['type' => 0, 'content' => 'Kasir: '.$trx->kasir->name, 'align' => 1];

//         if ($trx->nama_pelanggan) {
//             $data[] = ['type' => 0, 'content' => 'Cust: '.$trx->nama_pelanggan, 'bold' => 1, 'align' => 1];
//         }

//         $data[] = ['type' => 0, 'content' => '------------------------------', 'align' => 1];

//         foreach ($itemDapur as $item) {
//             $data[] = ['type' => 0, 'content' => $item->produk->name . ' x' . $item->kuantitas, 'bold' => 1, 'align' => 0];
//         }

//         $data[] = ['type' => 0, 'content' => "\n\n\n\n" . chr(29) . chr(86) . chr(66) . chr(0)];
//     }

//     /* =========================
//     * STRUK BAR (MINUMAN)
//     * ========================= */
//     if ($itemMinuman->count() > 0) {
//         $data[] = ['type' => 0, 'content' => '*** PESANAN MINUMAN ***', 'bold' => 1, 'align' => 1, 'format' => 3];
//         $data[] = ['type' => 0, 'content' => 'Tgl: '.$trx->created_at->format('d/m/y H:i'), 'align' => 1];
//         $data[] = ['type' => 0, 'content' => 'Kasir: '.$trx->kasir->name, 'align' => 1];

//         if ($trx->nama_pelanggan) {
//             $data[] = ['type' => 0, 'content' => 'Cust: '.$trx->nama_pelanggan, 'bold' => 1, 'align' => 1];
//         }

//         $data[] = ['type' => 0, 'content' => '------------------------------', 'align' => 1];

//         foreach ($itemMinuman as $item) {
//             $namaDisplay = $item->produk->name;
//             // Penanda khusus untuk orang Bar jika itu produk paket
//             if (strtolower($item->produk->name) === 'paket 7k nasi + teh') {
//                 $namaDisplay .= " (AMBIL TEH)";
//             }

//             $data[] = ['type' => 0, 'content' => $namaDisplay . ' x' . $item->kuantitas, 'bold' => 1, 'align' => 0];
//         }

//         // $data[] = ['type' => 0, 'content' => "\n\n\n\n" . chr(29) . chr(86) . chr(66) . chr(0)];
//     }

//     echo json_encode($data, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
//     exit;
// });

Route::get('/android/receipt/{id}', function ($id) {
    header('Content-Type: application/json; charset=utf-8');

    $printType = request()->query('type', 'basic');
    $trx = Transaksi::with(['produkPivot.produk.kategori', 'kasir'])->find($id);

    if (!$trx) {
        echo '{}'; exit;
    }

    $rupiah = function ($amount) {
        return 'Rp. ' . number_format($amount, 0, ',', '.');
    };

    // FUNGSI HELPER: Rata Kiri & Kanan (48 Karakter untuk 80mm)
    $formatBaris = function ($kiri, $kanan, $lebarMaks = 48) {
        $lebarKanan = strlen($kanan);
        $lebarKiriTersedia = $lebarMaks - $lebarKanan - 1; // -1 untuk spasi minimal

        // Jika nama produk (kiri) terlalu panjang, kita bungkus (wrap)
        $namaProdukWrapped = wordwrap($kiri, $lebarKiriTersedia, "\n", true);
        $lines = explode("\n", $namaProdukWrapped);

        $result = "";
        $lastLineIndex = count($lines) - 1;

        for ($i = 0; $i <= $lastLineIndex; $i++) {
            $currentLine = $lines[$i];
            if ($i == $lastLineIndex) {
                // Baris terakhir nama produk digabung dengan harga di kanan
                $sisaSpasi = $lebarMaks - strlen($currentLine) - $lebarKanan;
                $result .= $currentLine . str_repeat(' ', $sisaSpasi) . $kanan;
            } else {
                // Baris pembungkus (tumpahannya)
                $result .= $currentLine . "\n";
            }
        }
        return $result;
    };

    $data = [];

    // 1. OPEN DRAWER (Hanya Tunai)
    if (strtolower($trx->metode_pembayaran) == 'tunai') {
        $data[] = ['type' => 0, 'content' => chr(27) . chr(112) . chr(48) . chr(25) . chr(250)];
    }

    // 2. LOOP STRUK
    for ($i=0; $i <= 1; $i++) {
        $data[] = ['type' => 0, 'content' => 'AL KINZA', 'bold' => 1, 'align' => 1, 'format' => 2];
        $data[] = ['type' => 0, 'content' => 'Invoice: '.$trx->kode_transaksi, 'align' => 0];
        $data[] = ['type' => 0, 'content' => 'Tanggal: '.$trx->created_at->format('d M Y H:i'), 'align' => 0];
        $data[] = ['type' => 0, 'content' => '------------------------------------------------', 'align' => 1];

        // LOOP PRODUK SEJAJAR
        foreach ($trx->produkPivot as $item) {
            if (!$item->produk) continue;

            $labelKiri = $item->produk->name;
            $labelKanan = $item->kuantitas . ' x ' . number_format($item->produk->harga, 0, ',', '.') . ' = ' . number_format($item->subtotal, 0, ',', '.');

            $data[] = [
                'type'    => 0,
                'content' => $formatBaris($labelKiri, $labelKanan, 48),
                'align'   => 0
            ];
        }

        $data[] = ['type' => 0, 'content' => '------------------------------------------------', 'align' => 1];

        // FOOTER PEMBAYARAN SEJAJAR
        $data[] = ['type' => 0, 'content' => $formatBaris('TOTAL', $rupiah($trx->subtotal), 48), 'bold' => 1];
        $data[] = ['type' => 0, 'content' => $formatBaris('BAYAR', $rupiah($trx->bayar), 48)];
        $data[] = ['type' => 0, 'content' => $formatBaris('KEMBALI', $rupiah($trx->kembali), 48)];

        $data[] = ['type' => 0, 'content' => '------------------------------------------------', 'align' => 1];
        $data[] = ['type' => 0, 'content' => 'TERIMA KASIH', 'align' => 1];

        // CUTTING
        if ($printType == 'basic' && $i == 1) {
            $data[] = ['type' => 0, 'content' => "\n\n\n\n", 'align' => 0];
        } else {
            $data[] = ['type' => 0, 'content' => "\n\n\n\n" . chr(29) . chr(86) . chr(66) . chr(0)];
        }
    }

    // ... (Logika Struk Dapur/Bar silakan sesuaikan dengan fungsi $formatBaris jika perlu)

    echo json_encode($data, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
    exit;
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
