<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    protected $table = 'artikel';
    protected $fillable = ['user_id', 'judul', 'slug', 'konten', 'ringkasan', 'kategori', 'gambar', 'views', 'published', 'published_at'];

    protected $casts = ['published' => 'boolean', 'published_at' => 'datetime'];

    public function penulis()  { return $this->belongsTo(User::class, 'user_id'); }

    public function getKategoriLabelAttribute(): string
    {
        return match($this->kategori) {
            'panduan'   => 'Panduan',
            'berita'    => 'Berita',
            'tips'      => 'Tips & Trik',
            'teknologi' => 'Teknologi',
            'cuaca'     => 'Info Cuaca',
            default     => ucfirst($this->kategori),
        };
    }

    public function scopePublished($query) { return $query->where('published', true); }
}
