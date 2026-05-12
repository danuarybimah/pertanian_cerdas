<?php

namespace App\Repositories\Interfaces;

interface HargaPasarRepositoryInterface
{
    public function all();
    public function terkini();
    public function byKomoditas(int $komoditasId, int $hari = 30);
    public function byTanggal(string $tanggal);
    public function create(array $data);
    public function statistikHarga(int $komoditasId);
}
