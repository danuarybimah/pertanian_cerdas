<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\HargaPasarRepositoryInterface;
use App\Repositories\Interfaces\KomoditasRepositoryInterface;
use App\Services\StatistikService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HargaPasarController extends Controller
{
    public function __construct(
        protected HargaPasarRepositoryInterface $hargaRepo,
        protected KomoditasRepositoryInterface  $komoditasRepo,
        protected StatistikService              $statistikService,
    ) {}

    public function index(Request $request)
    {
        $hargaTerkini = $this->hargaRepo->terkini();
        $komoditas    = $this->komoditasRepo->aktif();
        $selected     = $request->get('komoditas_id', $komoditas->first()?->id);
        $grafikData   = $selected ? $this->statistikService->getGrafikHarga((int)$selected) : ['labels'=>[],'values'=>[]];
        $riwayat      = $selected ? $this->hargaRepo->byKomoditas((int)$selected, 30) : collect();

        return view('harga-pasar.index', compact('hargaTerkini', 'komoditas', 'selected', 'grafikData', 'riwayat'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'komoditas_id' => 'required|exists:komoditas,id',
            'harga'        => 'required|numeric|min:0',
            'harga_min'    => 'nullable|numeric|min:0',
            'harga_max'    => 'nullable|numeric|min:0',
            'lokasi_pasar' => 'required|string|max:100',
            'tanggal'      => 'required|date',
            'sumber'       => 'nullable|string|max:100',
        ]);
        $data['input_by'] = Auth::id();
        $data['wilayah']  = Auth::user()->wilayah ?? 'Jawa Tengah';
        $this->hargaRepo->create($data);
        return back()->with('success', 'Data harga berhasil ditambahkan.');
    }
}
