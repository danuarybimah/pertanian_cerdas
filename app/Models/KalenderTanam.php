<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KalenderTanam extends Model
{
    protected $table = 'kalender_tanam';
    protected $fillable = ['komoditas_id','bulan_tanam','durasi_tanam','wilayah','musim','keterangan','varietas','produktivitas_rata'];

    public function komoditas() { return $this->belongsTo(Komoditas::class); }

    public function getBulanTanamLabelAttribute(): string
    {
        $bulan = ['', 'Januari','Februari','Maret','April','Mei','Juni',
                      'Juli','Agustus','September','Oktober','November','Desember'];
        return $bulan[$this->bulan_tanam] ?? '';
    }

    public function getBulanPanenAttribute(): int
    {
        $panen = $this->bulan_tanam + (int)ceil($this->durasi_tanam / 30);
        return $panen > 12 ? $panen - 12 : $panen;
    }
}
