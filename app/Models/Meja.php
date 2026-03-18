<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    protected $table = 'mejas';
    protected $fillable = [
        'token_meja',
        'kode_meja',
        'nomor_meja',
        'toko_id',
    ];

    public function getRouteKeyName()
    {
        return 'token_meja';
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'toko_id');
    }
}
