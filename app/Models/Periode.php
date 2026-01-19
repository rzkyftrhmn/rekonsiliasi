<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    protected $table = 'periodes';

    protected $fillable = [
        'nama_periode',
        'tahun',
        'aktif',
    ];

    public function rekonsiliasis()
    {
        return $this->hasMany(Rekonsiliasi::class);
    }
}
