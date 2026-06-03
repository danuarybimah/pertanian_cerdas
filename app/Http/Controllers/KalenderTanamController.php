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
        $validated = $request->validate([
            'komoditas'          => 'required|string|max:255',
            'bulan_tanam'        => 'required|integer|between:1,12',
            'durasi_tanam'       => 'required|integer|min:1',
            'wilayah'            => 'required|string|max:100',
            'musim'              => 'required|in:hujan,kemarau,semua',
            'keterangan'         => 'nullable|string',
            'varietas'           => 'nullable|string|max:100',
            'produktivitas_rata' => 'nullable|numeric|min:0',
        ]);

        $komoditasName = trim($validated['komoditas']);

        // Find or dynamically create the Komoditas record
        $komoditasRecord = \App\Models\Komoditas::where('nama', $komoditasName)->first();

        if (!$komoditasRecord) {
            $baseSlug = \Illuminate\Support\Str::slug($komoditasName);
            $slug = $baseSlug;
            $counter = 1;
            while (\App\Models\Komoditas::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $komoditasRecord = \App\Models\Komoditas::create([
                'nama'   => $komoditasName,
                'slug'   => $slug,
                'aktif'  => true,
            ]);
        }

        // Map to data format expected by database
        $storeData = $validated;
        unset($storeData['komoditas']);
        $storeData['komoditas_id'] = $komoditasRecord->id;

        KalenderTanam::create($storeData);

        return redirect()->route('kalender-tanam.index', ['bulan' => $storeData['bulan_tanam']])
            ->with('success', 'Kalender tanam berhasil ditambahkan!');
    }
}
