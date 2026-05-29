<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\HargaPasarRepositoryInterface;
use App\Repositories\Interfaces\KomoditasRepositoryInterface;
use App\Services\StatistikService;
use App\Models\HargaPasar;
use App\Models\Komoditas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function create(Request $request)
    {
        $komoditas = $this->komoditasRepo->aktif();
        
        // Filter untuk riwayat harga pasar
        $filterTanggal = $request->get('filter_tanggal', date('Y-m-d'));
        $filterPasar   = $request->get('filter_pasar');
        
        $query = HargaPasar::with('komoditas')
            ->orderByDesc('tanggal')
            ->orderByDesc('id');
            
        if ($filterTanggal) {
            $query->where('tanggal', $filterTanggal);
        }
        if ($filterPasar) {
            $query->where('lokasi_pasar', 'like', "%{$filterPasar}%");
        }
        
        $riwayatTerkini = $query->take(15)->get();
        
        // Statistik harga naik/turun untuk tiap komoditas dibanding entri sebelumnya
        $statistik = [];
        foreach ($komoditas as $k) {
            $latest = HargaPasar::where('komoditas_id', $k->id)->orderByDesc('tanggal')->first();
            if ($latest) {
                $prev = HargaPasar::where('komoditas_id', $k->id)
                    ->where('tanggal', '<', $latest->tanggal)
                    ->orderByDesc('tanggal')
                    ->first();
                    
                if ($prev) {
                    $diff = $latest->harga - $prev->harga;
                    $pct = $prev->harga > 0 ? ($diff / $prev->harga) * 100 : 0;
                    $statistik[$k->id] = [
                        'nama' => $k->nama,
                        'harga' => $latest->harga,
                        'diff' => $diff,
                        'pct' => round($pct, 1),
                        'pasar' => $latest->lokasi_pasar,
                    ];
                } else {
                    $statistik[$k->id] = [
                        'nama' => $k->nama,
                        'harga' => $latest->harga,
                        'diff' => 0,
                        'pct' => 0,
                        'pasar' => $latest->lokasi_pasar,
                    ];
                }
            }
        }
        
        return view('harga-pasar.create', compact('komoditas', 'riwayatTerkini', 'statistik', 'filterTanggal', 'filterPasar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.komoditas_id' => 'required|exists:komoditas,id',
            'items.*.harga' => 'required|numeric|min:0',
            'items.*.lokasi_pasar' => 'required|string|max:100',
            'items.*.tanggal' => 'required|date',
        ]);

        $items = $request->input('items', []);

        // 1. Validasi Duplikasi di dalam form (input baru)
        $seen = [];
        foreach ($items as $item) {
            $key = $item['komoditas_id'] . '-' . strtolower(trim($item['lokasi_pasar'])) . '-' . $item['tanggal'];
            if (in_array($key, $seen)) {
                $komoditasNama = Komoditas::find($item['komoditas_id'])?->nama ?? 'Komoditas';
                return redirect()->back()->withInput()->with('error', "Duplikasi input terdeteksi: Komoditas \"{$komoditasNama}\" pada tanggal dan pasar yang sama dimasukkan lebih dari sekali dalam form.");
            }
            $seen[] = $key;
        }

        // 2. Validasi Duplikasi dengan Database
        foreach ($items as $item) {
            $exists = HargaPasar::where('komoditas_id', $item['komoditas_id'])
                ->where('lokasi_pasar', trim($item['lokasi_pasar']))
                ->where('tanggal', $item['tanggal'])
                ->exists();
            if ($exists) {
                $komoditasNama = Komoditas::find($item['komoditas_id'])?->nama ?? 'Komoditas';
                return redirect()->back()->withInput()->with('error', "Data harga untuk \"{$komoditasNama}\" di \"{$item['lokasi_pasar']}\" pada tanggal {$item['tanggal']} sudah terdaftar di database.");
            }
        }

        // 3. Simpan data menggunakan database transaction
        DB::beginTransaction();
        try {
            foreach ($items as $item) {
                $data = [
                    'komoditas_id' => $item['komoditas_id'],
                    'harga'        => $item['harga'],
                    'harga_min'    => $item['harga'] * 0.95,
                    'harga_max'    => $item['harga'] * 1.05,
                    'lokasi_pasar' => trim($item['lokasi_pasar']),
                    'tanggal'      => $item['tanggal'],
                    'sumber'       => Auth::user()->name,
                    'input_by'     => Auth::id(),
                    'wilayah'      => Auth::user()->wilayah ?? 'Jawa Tengah',
                ];
                $this->hargaRepo->create($data);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem saat menyimpan data: ' . $e->getMessage());
        }

        return redirect()->route('harga-pasar.index')->with('success', 'Berhasil menyimpan ' . count($items) . ' data harga komoditas!');
    }
}
