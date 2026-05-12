<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HargaPasar extends Model
{
    protected $table = 'harga_pasar';
    protected $fillable = ['komoditas_id', 'harga', 'harga_min', 'harga_max', 'lokasi_pasar', 'wilayah', 'tanggal', 'sumber', 'input_by'];

    protected $casts = ['tanggal' => 'date', 'harga' => 'decimal:2'];

    public function komoditas() { return $this->belongsTo(Komoditas::class); }
    public function inputBy()   { return $this->belongsTo(User::class, 'input_by'); }

    public function getTrendAttribute(): string
    {
        // Simplified: compared to yesterday
        $prev = static::where('komoditas_id', $this->komoditas_id)
            ->where('tanggal', '<', $this->tanggal)
            ->orderByDesc('tanggal')->first();
        if (!$prev) return 'stable';
        if ($this->harga > $prev->harga) return 'up';
        if ($this->harga < $prev->harga) return 'down';
        return 'stable';
    }
}
