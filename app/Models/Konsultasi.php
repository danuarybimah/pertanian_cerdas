<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    protected $table = 'konsultasi';
    protected $fillable = ['petani_id','penyuluh_id','judul','pertanyaan','tanaman','status','prioritas','views'];

    public function petani()   { return $this->belongsTo(User::class, 'petani_id'); }
    public function penyuluh() { return $this->belongsTo(User::class, 'penyuluh_id'); }
    public function jawaban()  { return $this->hasMany(JawabanKonsultasi::class); }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'open'        => 'Menunggu Jawaban',
            'in_progress' => 'Sedang Diproses',
            'answered'    => 'Sudah Dijawab',
            'closed'      => 'Ditutup',
            default       => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'open'        => 'warning',
            'in_progress' => 'info',
            'answered'    => 'success',
            'closed'      => 'secondary',
            default       => 'secondary',
        };
    }
}
