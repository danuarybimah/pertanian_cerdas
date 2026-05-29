<?php

namespace App\Repositories;

use App\Models\Konsultasi;
use App\Models\JawabanKonsultasi;
use App\Repositories\Interfaces\KonsultasiRepositoryInterface;

class KonsultasiRepository implements KonsultasiRepositoryInterface
{
    public function __construct(
        protected Konsultasi $model,
        protected JawabanKonsultasi $jawabanModel
    ) {}

    public function all()
    {
        return $this->model->with(['petani','penyuluh','jawaban'])
            ->orderByDesc('created_at')->paginate(15);
    }

    public function byPetani(int $petaniId)
    {
        return $this->model->where('petani_id', $petaniId)
            ->with('jawaban')->orderByDesc('created_at')->get();
    }

    public function byPenyuluh(int $penyuluhId)
    {
        return $this->model->where(function($query) use ($penyuluhId) {
                $query->where('penyuluh_id', $penyuluhId)
                      ->orWhere('status', '!=', 'closed');
            })
            ->with(['petani','jawaban'])->orderByDesc('created_at')->get();
    }

    public function open()
    {
        return $this->model->where('status', '!=', 'closed')
            ->with('petani')->orderByDesc('created_at')->get();
    }

    public function findById(int $id)
    {
        return $this->model->with(['petani','penyuluh','jawaban.penjawab'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $k = $this->model->findOrFail($id);
        $k->update($data);
        return $k;
    }

    public function addJawaban(int $konsultasiId, array $data)
    {
        $jawaban = $this->jawabanModel->create(array_merge($data, ['konsultasi_id' => $konsultasiId]));
        $this->model->findOrFail($konsultasiId)->update(['status' => 'answered']);
        return $jawaban;
    }

    public function incrementViews(int $id)
    {
        $this->model->where('id', $id)->increment('views');
    }
}
