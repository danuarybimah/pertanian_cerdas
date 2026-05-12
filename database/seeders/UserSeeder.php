<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            // ===== DINAS =====
            [
                'name'     => 'Dinas Pertanian Jawa Tengah',
                'email'    => 'dinas@sipertani.id',
                'password' => Hash::make('password123'),
                'role'     => 'dinas',
                'wilayah'  => 'Jawa Tengah',
                'bio'      => 'Dinas Pertanian dan Perkebunan Provinsi Jawa Tengah.',
            ],

            // ===== PENYULUH =====
            [
                'name'     => 'Pak Hendra Penyuluh',
                'email'    => 'hendra@sipertani.id',
                'password' => Hash::make('password123'),
                'role'     => 'penyuluh',
                'wilayah'  => 'Semarang',
                'bio'      => 'Penyuluh pertanian lapangan wilayah Semarang.',
            ],
            [
                'name'     => 'Bu Sari Penyuluh',
                'email'    => 'sari@sipertani.id',
                'password' => Hash::make('password123'),
                'role'     => 'penyuluh',
                'wilayah'  => 'Demak',
                'bio'      => 'Penyuluh pertanian lapangan wilayah Demak.',
            ],

            // ===== PETANI =====
            [
                'name'     => 'Budi Santoso',
                'email'    => 'budi@sipertani.id',
                'password' => Hash::make('password123'),
                'role'     => 'petani',
                'wilayah'  => 'Semarang',
                'bio'      => 'Petani padi di wilayah Semarang.',
            ],
            [
                'name'     => 'Slamet Riyadi',
                'email'    => 'slamet@sipertani.id',
                'password' => Hash::make('password123'),
                'role'     => 'petani',
                'wilayah'  => 'Demak',
                'bio'      => 'Petani jagung dan kedelai di wilayah Demak.',
            ],
            [
                'name'     => 'Waginem',
                'email'    => 'waginem@sipertani.id',
                'password' => Hash::make('password123'),
                'role'     => 'petani',
                'wilayah'  => 'Kendal',
                'bio'      => 'Petani sayuran di wilayah Kendal.',
            ],
        ];

        foreach ($users as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                $data
            );
        }

        $this->command->info('✅ UserSeeder selesai: 1 dinas, 2 penyuluh, 3 petani.');
    }
}
