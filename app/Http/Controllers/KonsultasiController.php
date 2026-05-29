<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\KonsultasiRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KonsultasiController extends Controller
{
    public function __construct(protected KonsultasiRepositoryInterface $konsultasiRepo) {}

    public function index()
    {
        $user = Auth::user();
        if ($user->isPetani()) {
            $konsultasi = $this->konsultasiRepo->byPetani($user->id);
        } elseif ($user->isPenyuluh()) {
            $konsultasi = $this->konsultasiRepo->byPenyuluh($user->id);
        } else {
            $konsultasi = $this->konsultasiRepo->all();
        }
        return view('konsultasi.index', compact('konsultasi'));
    }

    public function create()
    {
        abort_unless(Auth::user()->isPetani(), 403, 'Hanya petani yang dapat membuat konsultasi.');
        return view('konsultasi.create');
    }

    public function store(Request $request)
    {
        abort_unless(Auth::user()->isPetani(), 403);
        $data = $request->validate([
            'judul'      => 'required|string|max:255',
            'pertanyaan' => 'required|string|min:20',
            'tanaman'    => 'nullable|string|max:100',
            'prioritas'  => 'required|in:rendah,sedang,tinggi',
        ]);
        $data['petani_id'] = Auth::id();
        $k = $this->konsultasiRepo->create($data);
        return redirect()->route('konsultasi.show', $k->id)->with('success', 'Konsultasi berhasil dikirim!');
    }

    public function show(int $id)
    {
        $konsultasi = $this->konsultasiRepo->findById($id);
        $this->konsultasiRepo->incrementViews($id);
        return view('konsultasi.show', compact('konsultasi'));
    }

    public function jawab(Request $request, int $id)
    {
        abort_unless(Auth::user()->isPenyuluh() || Auth::user()->isDinas(), 403);
        $request->validate(['jawaban' => 'required|string|min:10']);
        
        $konsultasi = $this->konsultasiRepo->findById($id);
        if ($konsultasi->status === 'closed') {
            return back()->with('error', 'Konsultasi ini telah ditutup.');
        }

        $sudahJawab = $konsultasi->jawaban->contains('user_id', Auth::id());
        if ($sudahJawab) {
            return back()->with('error', 'Anda sudah memberikan jawaban untuk konsultasi ini.');
        }

        $this->konsultasiRepo->addJawaban($id, [
            'user_id' => Auth::id(),
            'jawaban' => $request->jawaban,
        ]);
        return back()->with('success', 'Jawaban berhasil dikirim!');
    }

    public function tutup(int $id)
    {
        $k = $this->konsultasiRepo->findById($id);
        abort_if($k->petani_id !== Auth::id(), 403);
        $this->konsultasiRepo->update($id, ['status' => 'closed']);
        return back()->with('success', 'Konsultasi ditutup.');
    }
}
