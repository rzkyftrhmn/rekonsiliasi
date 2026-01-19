<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    protected $table = 'rekenings';

    protected $fillable = [
        'kode_rekening',
        'nama_rekening',
    ];

    public function rekonsiliasis()
    {
        return $this->hasMany(Rekonsiliasi::class);
    }
}
