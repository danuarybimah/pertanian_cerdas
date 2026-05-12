<?php

namespace App\Repositories;

use App\Models\HargaPasar;
use App\Repositories\Interfaces\HargaPasarRepositoryInterface;
use Illuminate\Support\Facades\DB;

class HargaPasarRepository implements HargaPasarRepositoryInterface
{
    public function __construct(protected HargaPasar $model) {}

    public function all()
    {
        return $this->model->with('komoditas')->orderByDesc('tanggal')->paginate(20);
    }

    public function terkini()
    {
        return $this->model
            ->with('komoditas')
            ->whereIn('id', function ($q) {
                $q->select(DB::raw('MAX(id)'))
                  ->from('harga_pasar')
                  ->groupBy('komoditas_id');
            })
            ->orderBy('tanggal', 'desc')
            ->get();
    }

    public function byKomoditas(int $komoditasId, int $hari = 30)
    {
        return $this->model
            ->where('komoditas_id', $komoditasId)
            ->where('tanggal', '>=', now()->subDays($hari)->toDateString())
            ->orderBy('tanggal')
            ->get();
    }

    public function byTanggal(string $tanggal)
    {
        return $this->model->with('komoditas')->where('tanggal', $tanggal)->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function statistikHarga(int $komoditasId)
    {
        return $this->model
            ->where('komoditas_id', $komoditasId)
            ->where('tanggal', '>=', now()->subDays(30)->toDateString())
            ->selectRaw('AVG(harga) as avg, MAX(harga) as max, MIN(harga) as min, COUNT(*) as total')
            ->first();
    }
}
