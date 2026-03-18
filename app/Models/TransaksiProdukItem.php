<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiProdukItem extends Model
{
    protected $table = 'transaksi_produk_items';
    protected $guarded = ['id'];

    public function transaksiProduct()
    {
        return $this->belongsTo(TransaksiProduct::class, 'transaksi_product_id');
    }
}
