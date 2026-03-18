<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksis';
    protected $guarded = ['id'];

    public function produkPivot()
    {
        return $this->hasMany(TransaksiProduct::class, 'kode_transaksi', 'kode_transaksi');
    }

    public function allItems()
    {
        return $this->hasManyThrough(
            TransaksiProdukItem::class,
            TransaksiProduct::class,
            'transaksi_id',          // Foreign key di transaksi_products
            'transaksi_product_id',  // Foreign key di transaksi_product_items
            'id',                    // Primary key di transaksis
            'id'                     // Primary key di transaksi_products
        );
    }

    public function meja()
    {
        return $this->belongsTo(Meja::class, 'meja_id', 'id');
    }

    /**
     * Relasi ke kasir (User yang melakukan transaksi)
     */
    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id', 'id');
    }

    /**
     * Relasi ke user (pelanggan)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relasi ke toko
     */
    public function toko()
    {
        return $this->belongsTo(Toko::class, 'toko_id', 'id');
    }
}
