<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Skpd;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // =========================
        // ADMIN
        // =========================
        User::create([
            'name' => 'Admin Sistem',
            'username' => 'admin',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        // =========================
        // OPERATOR (SKPD)
        // =========================
        $skpd = Skpd::where('jenis', 'skpd')->first();

        if ($skpd) {
            User::create([
                'name' => 'Operator SKPD',
                'username' => 'operator',
                'role' => 'operator',
                'skpd_id' => $skpd->id,
                'password' => Hash::make('password'),
            ]);
        }

        // =========================
        // VALIDATOR
        // =========================
        User::create([
            'name' => 'Validator',
            'username' => 'validator',
            'role' => 'validator',
            'password' => Hash::make('password'),
        ]);
    }
}
