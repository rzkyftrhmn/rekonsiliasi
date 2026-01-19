<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skpd extends Model
{
    protected $table = 'skpds';

    protected $fillable = [
        'nama_skpd',
        'jenis',
    ];

    public function rekonsiliasis()
    {
        return $this->hasMany(Rekonsiliasi::class);
    }
}
