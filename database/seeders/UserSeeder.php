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
                'name'     => 'Dinas Pertanian Jawa Timur',
                'email'    => 'dinasjatim@gmail.com',
                'password' => Hash::make('password'),
                'role'     => 'dinas',
                'wilayah'  => 'Jawa Timur',
                'bio'      => 'Dinas Pertanian dan Perkebunan Provinsi Jawa Timur.',
            ],
        ];
        foreach ($users as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                $data
            );
        }

        $this->command->info('UserSeeder selesai: 1 dinas.');
    }
}
