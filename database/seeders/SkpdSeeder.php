<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skpd;

class SkpdSeeder extends Seeder
{
    public function run(): void
    {
        Skpd::create([
            'nama_skpd' => 'Dinas Kesehatan',
            'jenis' => 'skpd',
        ]);

        Skpd::create([
            'nama_skpd' => 'BPKAD',
            'jenis' => 'bpkad',
        ]);
    }
}
