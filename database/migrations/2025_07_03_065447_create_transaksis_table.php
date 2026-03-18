<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi', 16)->unique();
            $table->foreignId('toko_id')->constrained('tokos')->cascadeOnDelete();
            $table->foreignId('meja_id')->nullable()->constrained('mejas')->nullOnDelete();
            $table->foreignId('kasir_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nama_pelanggan', 100)->nullable();
            $table->string('no_telepon', 15)->nullable();
            $table->unsignedInteger('kuantitas')->default(0);
            $table->decimal('diskon', 5, 2)->default(0);
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('total_harga', 15, 2)->default(0);
            $table->decimal('bayar', 15, 2)->default(0);
            $table->decimal('kembali', 15, 2)->default(0);
            $table->enum('metode_pembayaran', ['tunai', 'non-tunai', 'pending'])->default('tunai');
            $table->enum('jenis_transaksi', ['pesanan', 'ditempat'])->default('ditempat');
            $table->enum('status', ['keranjang', 'pending', 'proses', 'selesai', 'batal', 'menanti'])->default('keranjang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('transaksis');
        Schema::enableForeignKeyConstraints();
    }
};
