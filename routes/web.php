<?php

use App\Http\Controllers\Admin\{KategoriController, TokoController, ProductController, KasController, MejaController};
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/menu/{token_toko}', [ShopController::class, 'menu'])->name('shop.menu');

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/shop/get-data-keranjang', [ShopController::class, 'getDataKeranjang']);
    Route::post('/shop/add-to-cart', [ShopController::class, 'postDataKeranjang']);
    Route::post('/shop/update-cart-item', [ShopController::class, 'updateKeranjang']);
    Route::post('/shop/checkout', [ShopController::class, 'checkout']);

    Route::get('/pesanan/{token_toko}', [ShopController::class, 'pesanan'])->name('shop.pesanan');
});

// routes/web.php

Route::middleware(['auth', 'role:core|admin|operator'])->group(function () {
    // Route untuk tampilkan halaman dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route untuk get data dashboard via AJAX
    Route::get('/dashboard/data', [DashboardController::class, 'getData'])->name('dashboard.data');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['auth', 'role:core|admin|operator'])->group(function () {
        // kategori
        Route::resource('/kategori', KategoriController::class)->except(['create', 'edit', 'show']);

        // Kas
        Route::resource('/kas', KasController::class)->except(['create', 'edit', 'show']);
        Route::get('/laporan-transaksi', [KasController::class, 'laporan_transaksi'])->name('laporan.transaksi');
        Route::post('/pembatalan-transaksi/{id}', [KasController::class, 'update_pembatalan'])->name('transaksi.pembatalan.update');
        Route::get('/laporan-shift', [KasController::class, 'laporan_shift'])->name('laporan.shift');
        Route::get('/approve-kas/{token_kas}', [KasController::class, 'approve'])->name('kas.approve');
        Route::get('/reject-kas/{token_kas}', [KasController::class, 'reject'])->name('kas.reject');

        // Produk
        Route::resource('/produk', ProductController::class)->except(['create', 'edit', 'show']);

        // Stok
        Route::get('/produk/stok', [ProductController::class, 'stok'])->name('produk.stok');
        Route::patch('produk-stok/{product}/update', [ProductController::class, 'update_stok'])->name('produk-stok.update');

        // Harga
        Route::patch('produk-stok/{product}/update-harga', [ProductController::class, 'update_harga'])->name('produk-stok.update-harga');
    });
    Route::middleware(['auth', 'role:admin|core'])->group(function () {
        // Toko
        Route::resource('/toko', TokoController::class)->except(['create', 'edit', 'show']);

        // Meja
        Route::resource('/meja', MejaController::class)->except(['create', 'edit', 'show']);
    });
});

require __DIR__ . '/auth.php';
require __DIR__ . '/spatie.php';
require __DIR__ . '/pos.php';
