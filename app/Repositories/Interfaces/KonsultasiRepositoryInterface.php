<?php

namespace App\Repositories\Interfaces;

interface KonsultasiRepositoryInterface
{
    public function all();
    public function byPetani(int $petaniId);
    public function byPenyuluh(int $penyuluhId);
    public function open();
    public function findById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function addJawaban(int $konsultasiId, array $data);
    public function incrementViews(int $id);
}
