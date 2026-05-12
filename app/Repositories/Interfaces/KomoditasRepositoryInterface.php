<?php

namespace App\Repositories\Interfaces;

interface KomoditasRepositoryInterface
{
    public function all();
    public function aktif();
    public function findById(int $id);
    public function findBySlug(string $slug);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
