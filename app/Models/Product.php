<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'token_product';
    protected $keyType = 'string';
    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'token_product';
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function transaksiPivots()
    {
        return $this->hasMany(TransaksiProduct::class, 'produk_id', 'id');
    }

    public function transaksiItems()
    {
        return $this->hasManyThrough(
            TransaksiProdukItem::class,
            TransaksiProduct::class,
            'produk_id',
            'transaksi_product_id',
            'id',
            'id'
        );
    }
}
