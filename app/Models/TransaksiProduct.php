<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiProduct extends Model
{
    protected $table = 'transaksi_products';
    protected $guarded = ['id'];

    public function produk()
    {
        return $this->belongsTo(Product::class, 'produk_id', 'id');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'kode_transaksi', 'kode_transaksi');
    }

    public function items()
    {
        return $this->hasOne(TransaksiProdukItem::class, 'transaksi_product_id');
    }
}
