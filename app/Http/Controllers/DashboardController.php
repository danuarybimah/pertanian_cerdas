<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\KonsultasiRepositoryInterface;
use App\Repositories\Interfaces\ArtikelRepositoryInterface;
use App\Repositories\Interfaces\HargaPasarRepositoryInterface;
use App\Services\CuacaService;
use App\Services\StatistikService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(
        protected KonsultasiRepositoryInterface $konsultasiRepo,
        protected ArtikelRepositoryInterface    $artikelRepo,
        protected HargaPasarRepositoryInterface $hargaRepo,
        protected CuacaService                  $cuacaService,
        protected StatistikService              $statistikService,
    ) {}

    public function index()
    {
        /** @var \App\Models\User $user */
        $user   = Auth::user();
        $wilayahMentah = $user->wilayah ?? 'Jawa Timur';
        if (str_contains($wilayahMentah, ',')) {
            $wilayahUser = trim(explode(',', $wilayahMentah)[0]);
        } else {
            $wilayahUser = str_replace(['Dinas Pertanian dan Perkebunan Provinsi', 'Dinas Pertanian', 'dan Perkebunan'], '', $wilayahMentah);
            $wilayahUser = trim($wilayahUser);
        }
        $cuaca  = $this->cuacaService->getData($wilayahUser);
        $harga  = $this->hargaRepo->terkini()->take(6);
        $statistik = $this->statistikService->getDampak();

        if ($user->isPetani()) {
            $konsultasi = $this->konsultasiRepo->byPetani($user->id);
            $artikel    = $this->artikelRepo->published()->getCollection()->take(3);
            return view('dashboard.petani', compact('cuaca', 'harga', 'konsultasi', 'artikel', 'statistik'));
        }

        if ($user->isPenyuluh()) {
            $konsultasiOpen = $this->konsultasiRepo->open();
            $artikelSaya    = $this->artikelRepo->byPenulis($user->id);
            $grafikKonsultasi = $this->statistikService->getGrafikKonsultasi();
            return view('dashboard.penyuluh', compact('cuaca', 'harga', 'konsultasiOpen', 'artikelSaya', 'statistik', 'grafikKonsultasi'));
        }

        // dinas
        $grafikKonsultasi = $this->statistikService->getGrafikKonsultasi();
        $allKonsultasi    = $this->konsultasiRepo->all();
        return view('dashboard.dinas', compact('cuaca', 'harga', 'statistik', 'grafikKonsultasi', 'allKonsultasi'));
    }
}
