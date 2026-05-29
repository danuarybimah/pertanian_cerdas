<?php

namespace App\Http\Controllers;

use App\Models\KalenderTanam;
use App\Repositories\Interfaces\KomoditasRepositoryInterface;
use Illuminate\Http\Request;

class KalenderTanamController extends Controller
{
    public function __construct(protected KomoditasRepositoryInterface $komoditasRepo) {}

    public function index(Request $request)
    {
        $bulan = (int)$request->get('bulan', now()->month);
        $komoditas = $this->komoditasRepo->aktif();
        $kalender  = KalenderTanam::with('komoditas')
            ->where('bulan_tanam', $bulan)
            ->get();

        // Build 12-month overview
        $overview = [];
        for ($b = 1; $b <= 12; $b++) {
            $overview[$b] = KalenderTanam::with('komoditas')->where('bulan_tanam', $b)->get();
        }

        return view('kalender-tanam.index', compact('bulan', 'kalender', 'komoditas', 'overview'));
    }

    public function create()
    {
        $komoditas = $this->komoditasRepo->aktif();
        return view('kalender-tanam.create', compact('komoditas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'komoditas_id'       => 'required|exists:komoditas,id',
            'bulan_tanam'        => 'required|integer|between:1,12',
            'durasi_tanam'       => 'required|integer|min:1',
            'wilayah'            => 'required|string|max:100',
            'musim'              => 'required|in:hujan,kemarau,semua',
            'keterangan'         => 'nullable|string',
            'varietas'           => 'nullable|string|max:100',
            'produktivitas_rata' => 'nullable|numeric|min:0',
        ]);

        KalenderTanam::create($data);

        return redirect()->route('kalender-tanam.index', ['bulan' => $data['bulan_tanam']])
            ->with('success', 'Kalender tanam berhasil ditambahkan!');
    }
}
