<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KalenderTanam;
use App\Models\Komoditas;

class KalenderTanamSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada data komoditas terlebih dahulu
        $komoditasIds = Komoditas::pluck('id')->toArray();

        if (empty($komoditasIds)) {
            $this->command->warn('Data komoditas kosong. Silakan jalankan KomoditasSeeder terlebih dahulu!');
            return;
        }

        // Truncate data lama kalender tanam agar tidak terjadi penumpukan
        KalenderTanam::truncate();

        // Sampel data dummy bervariasi untuk bulan 1-12 (Januari s.d. Desember)
        // Disesuaikan dengan tipe data database (bulan_tanam = int, durasi_tanam = int hari, musim = enum, produktivitas_rata = decimal)
        $data = [
            [
                'bulan_tanam' => 1, // Januari
                'durasi_tanam' => 100, // ± 3 Bulan
                'wilayah' => 'Jawa Timur (Dataran Rendah)',
                'musim' => 'hujan',
                'varietas' => 'Inpari 32',
                'produktivitas_rata' => 6.20,
                'keterangan' => 'Padi varietas Inpari sangat baik ditanam awal tahun karena pasokan air melimpah dari curah hujan tinggi.',
            ],
            [
                'bulan_tanam' => 2, // Februari
                'durasi_tanam' => 120, // ± 4 Bulan
                'wilayah' => 'Jawa Tengah (Lahan Sawah)',
                'musim' => 'hujan',
                'varietas' => 'Ciherang',
                'produktivitas_rata' => 5.80,
                'keterangan' => 'Optimalkan sistem irigasi pembuangan (drainase) agar akar tanaman tidak membusuk akibat genangan air berlebih.',
            ],
            [
                'bulan_tanam' => 3, // Maret
                'durasi_tanam' => 90, // ± 3 Bulan
                'wilayah' => 'Jawa Barat (Dataran Rendah)',
                'musim' => 'semua',
                'varietas' => 'Pioner P35',
                'produktivitas_rata' => 7.50,
                'keterangan' => 'Jagung hibrida sangat cocok ditanam saat transisi musim hujan ke kemarau untuk memaksimalkan fotosintesis.',
            ],
            [
                'bulan_tanam' => 4, // April
                'durasi_tanam' => 85, // ± 3 Bulan
                'wilayah' => 'Nusa Tenggara Barat',
                'musim' => 'kemarau',
                'varietas' => 'Bima Kurana',
                'produktivitas_rata' => 8.20,
                'keterangan' => 'Sangat cocok untuk bawang merah. Pengairan dilakukan pagi atau sore hari secara tipis-tipis.',
            ],
            [
                'bulan_tanam' => 5, // Mei
                'durasi_tanam' => 105, // ± 3.5 Bulan
                'wilayah' => 'Dataran Tinggi Dieng',
                'musim' => 'kemarau',
                'varietas' => 'Granola XL',
                'produktivitas_rata' => 15.50,
                'keterangan' => 'Kentang membutuhkan tanah gembur dan suhu sejuk. Waspadai embun es/embun upas di daerah tinggi.',
            ],
            [
                'bulan_tanam' => 6, // Juni
                'durasi_tanam' => 95, // ± 3 Bulan
                'wilayah' => 'Jawa Timur (Lahan Tegal)',
                'musim' => 'kemarau',
                'varietas' => 'Dewata F1',
                'produktivitas_rata' => 1.20,
                'keterangan' => 'Cabai rawit ditanam pertengahan tahun untuk menghindari penyakit patek (antraknosa) akibat kelembapan tinggi.',
            ],
            [
                'bulan_tanam' => 7, // Juli
                'durasi_tanam' => 110, // ± 3.5 Bulan
                'wilayah' => 'Jawa Tengah (Lahan Kering)',
                'musim' => 'kemarau',
                'varietas' => 'Lokal Brebes',
                'produktivitas_rata' => 9.80,
                'keterangan' => 'Bawang merah Brebes sangat toleran dengan kekeringan, pastikan pemupukan organik dasar cukup kuat.',
            ],
            [
                'bulan_tanam' => 8, // Agustus
                'durasi_tanam' => 75, // ± 2.5 Bulan
                'wilayah' => 'Jawa Barat (Lahan Sawah)',
                'musim' => 'semua',
                'varietas' => 'Servo F1',
                'produktivitas_rata' => 18.00,
                'keterangan' => 'Tomat Servo tahan terhadap serangan virus gemini (daun kuning keriting) yang marak di musim kemarau.',
            ],
            [
                'bulan_tanam' => 9, // September
                'durasi_tanam' => 100, // ± 3 Bulan
                'wilayah' => 'Dataran Tinggi',
                'musim' => 'semua',
                'varietas' => 'Kuroda',
                'produktivitas_rata' => 12.50,
                'keterangan' => 'Wortel membutuhkan tanah berpasir halus yang gembur agar umbi dapat tumbuh lurus dan panjang maksimal.',
            ],
            [
                'bulan_tanam' => 10, // Oktober
                'durasi_tanam' => 90, // ± 3 Bulan
                'wilayah' => 'Sumatera Utara',
                'musim' => 'semua',
                'varietas' => 'Bisi-18',
                'produktivitas_rata' => 7.80,
                'keterangan' => 'Penanaman jagung saat pancaroba akhir tahun, curah hujan awal membantu fase vegetatif awal.',
            ],
            [
                'bulan_tanam' => 11, // November
                'durasi_tanam' => 120, // ± 4 Bulan
                'wilayah' => 'Jawa Tengah (Dataran Rendah)',
                'musim' => 'hujan',
                'varietas' => 'Inpari 42',
                'produktivitas_rata' => 6.50,
                'keterangan' => 'Padi sawah tadah hujan mulai ditanam seiring masuknya musim penghujan secara merata.',
            ],
            [
                'bulan_tanam' => 12, // Desember
                'durasi_tanam' => 95, // ± 3 Bulan
                'wilayah' => 'Nusa Tenggara Timur',
                'musim' => 'hujan',
                'varietas' => 'Lokal Madura',
                'produktivitas_rata' => 3.50,
                'keterangan' => 'Jagung lokal ditanam serentak untuk memanfaatkan musim basah yang relatif singkat di daerah semi-arit.',
            ],
        ];

        foreach ($data as $item) {
            // Ambil komoditas secara acak dari database
            $randomKomoditasId = $komoditasIds[array_rand($komoditasIds)];

            KalenderTanam::create([
                'komoditas_id' => $randomKomoditasId,
                'bulan_tanam' => $item['bulan_tanam'],
                'durasi_tanam' => $item['durasi_tanam'],
                'wilayah' => $item['wilayah'],
                'musim' => $item['musim'],
                'varietas' => $item['varietas'],
                'produktivitas_rata' => $item['produktivitas_rata'],
                'keterangan' => $item['keterangan'],
            ]);
        }
    }
}
