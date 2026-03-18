<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi_produk_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_product_id')->constrained('transaksi_products')->onDelete('cascade');
            $table->decimal('berat', 8, 2); // dalam gram
            $table->decimal('harga', 15, 2); // berat * harga_satuan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_produk_items');
    }
};
