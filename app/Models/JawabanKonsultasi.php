<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanKonsultasi extends Model
{
    protected $table = 'jawaban_konsultasi';
    protected $fillable = ['konsultasi_id', 'user_id', 'jawaban', 'is_best_answer'];
    protected $casts = ['is_best_answer' => 'boolean'];

    public function konsultasi() { return $this->belongsTo(Konsultasi::class); }
    public function penjawab()   { return $this->belongsTo(User::class, 'user_id'); }
}
