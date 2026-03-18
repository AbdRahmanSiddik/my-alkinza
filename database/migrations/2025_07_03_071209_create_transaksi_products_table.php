<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi_products', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->nullable();
            $table->foreignId('produk_id')->constrained('products')->onDelete('cascade');
            $table->enum('satuan', ['pcs', 'gram', 'porsi'])->default('pcs');
            $table->unsignedInteger('kuantitas')->default(0);
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('transaksi_products');

        Schema::enableForeignKeyConstraints();
    }
};
