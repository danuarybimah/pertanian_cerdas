<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CuacaService
{
    protected float $lat = -7.1500;
    protected float $lon = 110.1400;
    protected string $wilayah = 'Jawa Tengah';

    public function getData(): array
    {
        return Cache::remember('cuaca_data', 1800, function () {
            try {
                $response = Http::timeout(8)->get('https://api.open-meteo.com/v1/forecast', [
                    'latitude'         => $this->lat,
                    'longitude'        => $this->lon,
                    'current'          => 'temperature_2m,relative_humidity_2m,precipitation,wind_speed_10m,weather_code',
                    'daily'            => 'weather_code,temperature_2m_max,temperature_2m_min,precipitation_sum',
                    'timezone'         => 'Asia/Jakarta',
                    'forecast_days'    => 7,
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    return $this->parseData($data);
                }
            } catch (\Exception $e) {
                // fallback ke data dummy jika API gagal
            }
            return $this->dummyData();
        });
    }

    protected function parseData(array $data): array
    {
        $current = $data['current'] ?? [];
        $daily   = $data['daily'] ?? [];

        $forecast = [];
        $hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        for ($i = 0; $i < min(7, count($daily['time'] ?? [])); $i++) {
            $ts = strtotime($daily['time'][$i]);
            $forecast[] = [
                'tanggal'   => $daily['time'][$i],
                'hari'      => $hari[date('w', $ts)],
                'suhu_max'  => round($daily['temperature_2m_max'][$i] ?? 0, 1),
                'suhu_min'  => round($daily['temperature_2m_min'][$i] ?? 0, 1),
                'hujan'     => round($daily['precipitation_sum'][$i] ?? 0, 1),
                'kode'      => $daily['weather_code'][$i] ?? 0,
                'ikon'      => $this->getIkon($daily['weather_code'][$i] ?? 0),
                'deskripsi' => $this->getDeskripsi($daily['weather_code'][$i] ?? 0),
            ];
        }

        return [
            'wilayah'    => $this->wilayah,
            'suhu'       => round($current['temperature_2m'] ?? 28, 1),
            'kelembapan' => $current['relative_humidity_2m'] ?? 75,
            'hujan'      => round($current['precipitation'] ?? 0, 1),
            'angin'      => round($current['wind_speed_10m'] ?? 10, 1),
            'kode'       => $current['weather_code'] ?? 0,
            'ikon'       => $this->getIkon($current['weather_code'] ?? 0),
            'deskripsi'  => $this->getDeskripsi($current['weather_code'] ?? 0),
            'forecast'   => $forecast,
            'updated_at' => now()->format('d M Y, H:i'),
            'rekomendasi'=> $this->getRekomendasi($current['weather_code'] ?? 0, $current['precipitation'] ?? 0),
        ];
    }

    protected function getIkon(int $code): string
    {
        if ($code === 0)              return '☀️';
        if ($code <= 3)              return '⛅';
        if ($code <= 48)             return '🌫️';
        if ($code <= 67)             return '🌧️';
        if ($code <= 77)             return '❄️';
        if ($code <= 82)             return '🌦️';
        return '⛈️';
    }

    protected function getDeskripsi(int $code): string
    {
        if ($code === 0)  return 'Cerah';
        if ($code <= 3)   return 'Berawan sebagian';
        if ($code <= 48)  return 'Berkabut';
        if ($code <= 55)  return 'Gerimis';
        if ($code <= 67)  return 'Hujan';
        if ($code <= 77)  return 'Salju';
        if ($code <= 82)  return 'Hujan deras';
        return 'Badai';
    }

    protected function getRekomendasi(int $code, float $hujan): string
    {
        if ($hujan > 5 || $code >= 61)
            return '⚠️ Cuaca hujan. Tunda penyemprotan pestisida. Pastikan drainase lahan berfungsi baik.';
        if ($code === 0 || $code <= 3)
            return '✅ Cuaca cerah, cocok untuk panen, penjemuran, dan pengolahan lahan.';
        return '🌤️ Cuaca cukup baik untuk kegiatan pertanian normal.';
    }

    protected function dummyData(): array
    {
        return [
            'wilayah'    => $this->wilayah,
            'suhu'       => 29.5,
            'kelembapan' => 78,
            'hujan'      => 0,
            'angin'      => 12,
            'kode'       => 2,
            'ikon'       => '⛅',
            'deskripsi'  => 'Berawan sebagian',
            'forecast'   => array_map(fn($i) => [
                'tanggal'   => now()->addDays($i)->toDateString(),
                'hari'      => ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'][now()->addDays($i)->dayOfWeek],
                'suhu_max'  => rand(30, 35),
                'suhu_min'  => rand(22, 26),
                'hujan'     => round(rand(0, 20) / 10, 1),
                'kode'      => $i % 3 === 0 ? 61 : 2,
                'ikon'      => $i % 3 === 0 ? '🌧️' : '⛅',
                'deskripsi' => $i % 3 === 0 ? 'Hujan' : 'Berawan',
            ], range(0, 6)),
            'updated_at' => now()->format('d M Y, H:i'),
            'rekomendasi'=> '✅ Cuaca cukup baik untuk kegiatan pertanian normal.',
        ];
    }
}
