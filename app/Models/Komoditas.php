<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komoditas extends Model
{
    protected $table = 'komoditas';
    protected $fillable = ['nama', 'slug', 'satuan', 'deskripsi', 'gambar', 'kategori', 'aktif'];

    protected $casts = ['aktif' => 'boolean'];

    public function hargaPasar()   { return $this->hasMany(HargaPasar::class); }
    public function kalenderTanam(){ return $this->hasMany(KalenderTanam::class); }

    public function hargaTerkini()
    {
        return $this->hasOne(HargaPasar::class)->latestOfMany('tanggal');
    }

    public function getKategoriLabelAttribute(): string
    {
        return ucfirst($this->kategori);
    }
}
