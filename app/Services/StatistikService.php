<?php

namespace App\Services;

use App\Models\Konsultasi;
use App\Models\Artikel;
use App\Models\User;
use App\Models\HargaPasar;
use Illuminate\Support\Facades\DB;

class StatistikService
{
    public function getDampak(): array
    {
        return [
            'total_petani'       => User::where('role', 'petani')->count(),
            'total_penyuluh'     => User::where('role', 'penyuluh')->count(),
            'total_konsultasi'   => Konsultasi::count(),
            'konsultasi_selesai' => Konsultasi::where('status', 'answered')->orWhere('status', 'closed')->count(),
            'total_artikel'      => Artikel::where('published', true)->count(),
            'total_views_artikel'=> Artikel::sum('views'),
            'komoditas_aktif'    => \App\Models\Komoditas::where('aktif', true)->count(),
            'harga_terbaru'      => HargaPasar::whereDate('tanggal', today())->count(),
            'produktivitas_est'  => $this->estimasiProduktivitas(),
            'kenaikan_harga_pct' => $this->kenaikanHargaRataRata(),
        ];
    }

    public function getGrafikKonsultasi(): array
    {
        $data = Konsultasi::select(
               DB::raw("DATE_FORMAT(created_at, '%Y-%m') as bulan"),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        return [
            'labels' => $data->pluck('bulan')->map(fn($b) => $this->formatBulan($b))->toArray(),
            'values' => $data->pluck('total')->toArray(),
        ];
    }

    public function getGrafikHarga(int $komoditasId): array
    {
        $data = HargaPasar::where('komoditas_id', $komoditasId)
            ->where('tanggal', '>=', now()->subDays(30)->toDateString())
            ->orderBy('tanggal')
            ->get();

        return [
            'labels' => $data->pluck('tanggal')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d/m'))->toArray(),
            'values' => $data->pluck('harga')->toArray(),
        ];
    }

    protected function estimasiProduktivitas(): float
    {
        return \App\Models\KalenderTanam::whereNotNull('produktivitas_rata')
            ->avg('produktivitas_rata') ?? 5.2;
    }

    protected function kenaikanHargaRataRata(): float
    {
        // Bandingkan harga 7 hari terakhir vs 7 hari sebelumnya
        $recent = HargaPasar::where('tanggal', '>=', now()->subDays(7)->toDateString())->avg('harga') ?? 0;
        $prev   = HargaPasar::whereBetween('tanggal', [
            now()->subDays(14)->toDateString(),
            now()->subDays(7)->toDateString()
        ])->avg('harga') ?? 0;

        if ($prev == 0) return 0;
        return round((($recent - $prev) / $prev) * 100, 1);
    }

    protected function formatBulan(string $bulanStr): string
    {
        [$year, $month] = explode('-', $bulanStr);
        $nama = ['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        return ($nama[(int)$month] ?? $month) . ' ' . substr($year, 2);
    }
}
