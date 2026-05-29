<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'wilayah', 'bio',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Mengecek apakah user memiliki role petani.
     */
    public function isPetani(): bool
    {
        return $this->role === 'petani';
    }

    /**
     * Mengecek apakah user memiliki role penyuluh.
     */
    public function isPenyuluh(): bool
    {
        return $this->role === 'penyuluh';
    }

    /**
     * Mengecek apakah user memiliki role dinas.
     */
    public function isDinas(): bool
    {
        return $this->role === 'dinas';
    }

    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'petani'   => 'Petani',
            'penyuluh' => 'Penyuluh Pertanian',
            'dinas'    => 'Dinas Pertanian',
            default    => 'Pengguna',
        };
    }

    public function konsultasi() { return $this->hasMany(Konsultasi::class, 'petani_id'); }
    public function jawaban()    { return $this->hasMany(JawabanKonsultasi::class); }
    public function artikel()    { return $this->hasMany(Artikel::class); }
}
