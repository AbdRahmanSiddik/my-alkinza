<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategoris';
    protected $fillable = [
        'token_kategori',
        'name',
        'icon',
    ];

    public function getRouteKeyName()
    {
        return 'token_kategori';
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'kategori_id');
    }
}
