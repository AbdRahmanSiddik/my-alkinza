<?php

use App\Http\Controllers\Admin\TokoController;
use App\Http\Controllers\Pos\KasirController;
use App\Http\Controllers\PrintController;
use App\Livewire\Pos;
use App\Livewire\RecentTransaction;
use Illuminate\Support\Facades\Route;

if (!function_exists('rupiah')) {
    function rupiah($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

Route::middleware('auth', 'role:core|admin|operator|kasir')->group(function () {
    Route::get('/sesi/toko/{token}', [TokoController::class, 'sessionToko'])->name('toko.sesi');

    // Route::get('/kasir', [KasirController::class, 'index'])->name('kasir');
    // Route::post('/kasir/order', [KasirController::class, 'store']);
    // Route::get('/kasir/show/{id}', [KasirController::class, 'show']);

    // Route::get('/post', [KasirController::class, 'indexes'])->name('kasir');
    // Route::get('/kasir/get-data-kategori', [KasirController::class, 'getKategori']);
    // Route::get('/kasir/get-data-produk/{kat}', [KasirController::class, 'getProduk']);
    // Route::get('/kasir/get-data-keranjang', [KasirController::class, 'getKeranjang']);
    // Route::get('/kasir/get-data-meja', [KasirController::class, 'getMeja']);
    // Route::get('/kasir/get-data-pesanan', [KasirController::class, 'getPesanan']);
    // Route::post('/kasir/post-transaksi-detail', [KasirController::class, 'postTransaksiDetail']);
    // Route::post('/kasir/update-transaksi-qty', [KasirController::class, 'updateTransaksiDetail']);
    // Route::get('/kasir/get-data-subtotal', [KasirController::class, 'getSubTotal']);
    // Route::post('/kasir/post-data-transaksi', [KasirController::class, 'postTransaksi']);
    // Route::get('/kasir/get-data-print/{transaksi}', [KasirController::class, 'printTransaksi']);
    // Route::get('/kasir/download-pdf/{transaksi}', [KasirController::class, 'downloadPdfTransaksi']);
    // Route::post('/kasir/delete-item', [KasirController::class, 'deleteItem']);

    Route::get('/post', Pos::class)->name('kasir');
    Route::get('/pos/receipt/{id}', function ($id) {
        $print = \App\Models\Transaksi::with('produkPivot.produk')->findOrFail($id);
        return view('partials.receipt', compact('print'));
    });
    Route::get('/transaksi', RecentTransaction::class)->name('transaksi');
    Route::get('/print-json/{id}', [PrintController::class, 'json']);
    // Route::get('/pos/receipt/android/{id}', function ($id) {
    //     $print = \App\Models\Transaksi::with('produkPivot.produk')->findOrFail($id);

    //     $data = [];

    //     // =====================
    //     // HEADER
    //     // =====================
    //     $data[] = [
    //         'type' => 0,
    //         'content' => session('toko.name'),
    //         'bold' => 1,
    //         'align' => 1,
    //         'format' => 2
    //     ];

    //     $data[] = [
    //         'type' => 0,
    //         'content' => 'Invoice: ' . $print->kode_transaksi,
    //         'align' => 0
    //     ];

    //     $data[] = [
    //         'type' => 0,
    //         'content' => 'Tanggal: ' . $print->created_at->format('d M Y H:i'),
    //         'align' => 0
    //     ];

    //     // =====================
    //     // PRODUK
    //     // =====================
    //     foreach ($print->produkPivot as $item) {
    //         $data[] = [
    //             'type' => 0,
    //             'content' =>
    //             $item->produk->name . "\n" .
    //                 $item->kuantitas . ' x ' . rupiah($item->produk->harga),
    //             'align' => 0
    //         ];

    //         $data[] = [
    //             'type' => 0,
    //             'content' => rupiah($item->subtotal),
    //             'align' => 2
    //         ];
    //     }

    //     // =====================
    //     // TOTAL
    //     // =====================
    //     $data[] = [
    //         'type' => 0,
    //         'content' => '------------------------',
    //         'align' => 1
    //     ];

    //     $data[] = [
    //         'type' => 0,
    //         'content' => 'Total : ' . rupiah($print->subtotal),
    //         'bold' => 1,
    //         'align' => 2
    //     ];

    //     $data[] = [
    //         'type' => 0,
    //         'content' => 'Bayar : ' . rupiah($print->bayar),
    //         'align' => 2
    //     ];

    //     $data[] = [
    //         'type' => 0,
    //         'content' => 'Kembali : ' . rupiah($print->kembali),
    //         'align' => 2
    //     ];

    //     // =====================
    //     // FOOTER
    //     // =====================
    //     $data[] = [
    //         'type' => 0,
    //         'content' => 'Terima kasih atas kunjungan Anda!',
    //         'align' => 1
    //     ];

    //     // return response()->json($data);
    //     return response()
    //     ->json($data, 200, [], JSON_FORCE_OBJECT);

    // });
});
