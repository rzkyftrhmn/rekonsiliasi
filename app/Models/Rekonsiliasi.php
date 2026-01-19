<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekonsiliasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'skpd_id',
        'rekening_id',
        'periode_id',
        'validator_id',
        'nilai_skpd',
        'nilai_bpkad',
        'status',
        'catatan',
    ];

    
    public function dokumen()
    {
        return $this->hasMany(DokumenRekonsiliasi::class);
    }

    public function skpd()
    {
        return $this->belongsTo(Skpd::class);
    }

    public function rekening()
    {
        return $this->belongsTo(Rekening::class);
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validator_id');
    }
}
