<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Komoditas;
use Illuminate\Support\Str;

class KomoditasSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Cabai Merah', 'satuan' => 'kg', 'kategori' => 'sayuran', 'deskripsi' => 'Cabai merah segar.'],
            ['nama' => 'Cabai Rawit', 'satuan' => 'kg', 'kategori' => 'sayuran', 'deskripsi' => 'Cabai rawit pedas.'],
            ['nama' => 'Bawang Merah', 'satuan' => 'kg', 'kategori' => 'rempah', 'deskripsi' => 'Bawang merah lokal.'],
            ['nama' => 'Bawang Putih', 'satuan' => 'kg', 'kategori' => 'rempah', 'deskripsi' => 'Bawang putih impor/lokal.'],
            ['nama' => 'Beras', 'satuan' => 'kg', 'kategori' => 'biji-bijian', 'deskripsi' => 'Beras putih premium.'],
            ['nama' => 'Jagung', 'satuan' => 'kg', 'kategori' => 'biji-bijian', 'deskripsi' => 'Jagung manis pipil.'],
            ['nama' => 'Tomat', 'satuan' => 'kg', 'kategori' => 'sayuran', 'deskripsi' => 'Tomat merah segar.'],
            ['nama' => 'Kentang', 'satuan' => 'kg', 'kategori' => 'sayuran', 'deskripsi' => 'Kentang Dieng.'],
            ['nama' => 'Wortel', 'satuan' => 'kg', 'kategori' => 'sayuran', 'deskripsi' => 'Wortel manis segar.'],
        ];

        foreach ($data as $item) {
            Komoditas::updateOrCreate(
                ['slug' => Str::slug($item['nama'])],
                [
                    'nama' => $item['nama'],
                    'satuan' => $item['satuan'],
                    'kategori' => $item['kategori'],
                    'deskripsi' => $item['deskripsi'],
                    'aktif' => true,
                ]
            );
        }
    }
}
