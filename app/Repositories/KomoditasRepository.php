<?php

namespace App\Repositories;

use App\Models\Komoditas;
use App\Repositories\Interfaces\KomoditasRepositoryInterface;

class KomoditasRepository implements KomoditasRepositoryInterface
{
    public function __construct(protected Komoditas $model) {}

    public function all()
    {
        return $this->model->with('hargaTerkini')->orderBy('nama')->get();
    }

    public function aktif()
    {
        return $this->model->where('aktif', true)->with('hargaTerkini')->orderBy('nama')->get();
    }

    public function findById(int $id)
    {
        return $this->model->with(['hargaPasar' => fn($q) => $q->orderByDesc('tanggal')->limit(30), 'kalenderTanam'])->findOrFail($id);
    }

    public function findBySlug(string $slug)
    {
        return $this->model->where('slug', $slug)->with('hargaTerkini')->firstOrFail();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $komoditas = $this->model->findOrFail($id);
        $komoditas->update($data);
        return $komoditas;
    }

    public function delete(int $id)
    {
        return $this->model->findOrFail($id)->delete();
    }
}
