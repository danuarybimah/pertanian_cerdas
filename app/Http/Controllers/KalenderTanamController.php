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
}
