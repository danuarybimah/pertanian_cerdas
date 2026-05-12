<?php

namespace App\Repositories;

use App\Models\Artikel;
use App\Repositories\Interfaces\ArtikelRepositoryInterface;
use Illuminate\Support\Str;

class ArtikelRepository implements ArtikelRepositoryInterface
{
    public function __construct(protected Artikel $model) {}

    public function all()
    {
        return $this->model->with('penulis')->orderByDesc('created_at')->get();
    }

    public function published()
    {
        return $this->model->published()->with('penulis')->orderByDesc('published_at')->paginate(9);
    }

    public function findById(int $id)
    {
        return $this->model->with('penulis')->findOrFail($id);
    }

    public function findBySlug(string $slug)
    {
        return $this->model->where('slug', $slug)->with('penulis')->firstOrFail();
    }

    public function byKategori(string $kategori)
    {
        return $this->model->published()->where('kategori', $kategori)->with('penulis')->paginate(9);
    }

    public function byPenulis(int $userId)
    {
        return $this->model->where('user_id', $userId)->orderByDesc('created_at')->get();
    }

    public function create(array $data)
    {
        $data['slug'] = Str::slug($data['judul']) . '-' . time();
        if (empty($data['ringkasan'])) {
            $data['ringkasan'] = Str::limit(strip_tags($data['konten']), 150);
        }
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $artikel = $this->model->findOrFail($id);
        $artikel->update($data);
        return $artikel;
    }

    public function delete(int $id)
    {
        return $this->model->findOrFail($id)->delete();
    }

    public function incrementViews(int $id)
    {
        $this->model->where('id', $id)->increment('views');
    }
}
