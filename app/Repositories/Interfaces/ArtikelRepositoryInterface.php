<?php

namespace App\Repositories\Interfaces;

interface ArtikelRepositoryInterface
{
    public function all();
    public function published();
    public function findById(int $id);
    public function findBySlug(string $slug);
    public function byKategori(string $kategori);
    public function byPenulis(int $userId);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function incrementViews(int $id);
}
