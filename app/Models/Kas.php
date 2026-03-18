<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kas extends Model
{
    protected $table = 'kas';
    protected $fillable = [
        'token_kas',
        'toko_id',
        'kasir_id',
        'nama',
        'jenis',
        'jumlah',
        'keterangan',
        'tanggal',
        'status',
    ];

    public function getRouteKeyName()
    {
        return 'token_kas';
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id', 'id');
    }
}
