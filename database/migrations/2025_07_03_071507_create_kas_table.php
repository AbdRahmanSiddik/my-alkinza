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
        Schema::create('kas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('toko_id')->constrained('tokos')->cascadeOnDelete();
            $table->string('token_kas', 8);
            $table->foreignId('kasir_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('nama', 100);
            $table->enum('jenis', ['pemasukan', 'pengeluaran']);
            $table->enum('status', ['selesai', 'diajukan', 'ditolak'])->default('diajukan');
            $table->decimal('jumlah', 15, 0)->default(0);
            $table->text('keterangan')->nullable();
            $table->date('tanggal')->default(now());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kas');
    }
};
