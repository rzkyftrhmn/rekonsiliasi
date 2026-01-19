<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenRekonsiliasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'rekonsiliasi_id',
        'nama_file',
        'path_file',
    ];

    public function rekonsiliasi()
    {
        return $this->belongsTo(Rekonsiliasi::class);
    }
}
