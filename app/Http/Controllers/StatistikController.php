<?php

namespace App\Http\Controllers;

use App\Services\StatistikService;
use App\Repositories\Interfaces\KomoditasRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    public function __construct(
        protected StatistikService             $statistikService,
        protected KomoditasRepositoryInterface $komoditasRepo,
    ) {}

    public function index(Request $request)
    {
        $dampak      = $this->statistikService->getDampak();
        $grafikKonsultasi = $this->statistikService->getGrafikKonsultasi();
        $komoditas   = $this->komoditasRepo->aktif();
        $selectedKomoditas = $request->get('komoditas_id', $komoditas->first()?->id);
        $grafikHarga = $selectedKomoditas
            ? $this->statistikService->getGrafikHarga((int)$selectedKomoditas)
            : ['labels'=>[],'values'=>[]];

        $petaniPerWilayah = User::where('role', 'petani')
            ->selectRaw('wilayah, COUNT(*) as total')
            ->groupBy('wilayah')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return view('statistik.index', compact('dampak', 'grafikKonsultasi', 'komoditas', 'selectedKomoditas', 'grafikHarga', 'petaniPerWilayah'));
    }
}
