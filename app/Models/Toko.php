<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    protected $fillable = ['token_toko', 'kode_toko', 'name', 'addres', 'deskripsi', 'logo'];

    public function getRouteKeyName()
    {
        return 'token_toko';
    }

    public function produks()
    {
        return $this->hasMany(Product::class, 'toko_id', 'id');
    }

    public function staff()
    {
        return $this->belongsToMany(User::class, 'pivot_staff', 'toko_id', 'staff_id');
    }
}
