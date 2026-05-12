<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\ArtikelRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtikelController extends Controller
{
    public function __construct(protected ArtikelRepositoryInterface $artikelRepo) {}

    public function index(Request $request)
    {
        $kategori = $request->get('kategori');
        $artikel  = $kategori
            ? $this->artikelRepo->byKategori($kategori)
            : $this->artikelRepo->published();
        return view('artikel.index', compact('artikel', 'kategori'));
    }

    public function show(string $slug)
    {
        $artikel = $this->artikelRepo->findBySlug($slug);
        $this->artikelRepo->incrementViews($artikel->id);
        $lainnya = $this->artikelRepo->byKategori($artikel->kategori)->getCollection()
            ->where('id', '!=', $artikel->id)->take(3);
        return view('artikel.show', compact('artikel', 'lainnya'));
    }

    public function create()
    {
        return view('artikel.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'    => 'required|string|max:255',
            'konten'   => 'required|string',
            'ringkasan'=> 'nullable|string|max:300',
            'kategori' => 'required|in:panduan,berita,tips,teknologi,cuaca',
            'published'=> 'boolean',
        ]);
        $data['user_id']      = Auth::id();
        $data['published']    = $request->boolean('published');
        $data['published_at'] = $data['published'] ? now() : null;

        $artikel = $this->artikelRepo->create($data);
        return redirect()->route('artikel.show', $artikel->slug)
            ->with('success', 'Artikel berhasil dipublikasikan!');
    }

    public function edit(int $id)
    {
        $artikel = $this->artikelRepo->findById($id);
        abort_if($artikel->user_id !== Auth::id() && !Auth::user()->isDinas(), 403);
        return view('artikel.edit', compact('artikel'));
    }

    public function update(Request $request, int $id)
    {
        $artikel = $this->artikelRepo->findById($id);
        abort_if($artikel->user_id !== Auth::id() && !Auth::user()->isDinas(), 403);

        $data = $request->validate([
            'judul'    => 'required|string|max:255',
            'konten'   => 'required|string',
            'ringkasan'=> 'nullable|string|max:300',
            'kategori' => 'required|in:panduan,berita,tips,teknologi,cuaca',
            'published'=> 'boolean',
        ]);
        $data['published']    = $request->boolean('published');
        $data['published_at'] = $data['published'] ? ($artikel->published_at ?? now()) : null;

        $this->artikelRepo->update($id, $data);
        return redirect()->route('artikel.show', $artikel->slug)->with('success', 'Artikel diperbarui!');
    }

    public function destroy(int $id)
    {
        $artikel = $this->artikelRepo->findById($id);
        abort_if($artikel->user_id !== Auth::id() && !Auth::user()->isDinas(), 403);
        $this->artikelRepo->delete($id);
        return redirect()->route('artikel.index')->with('success', 'Artikel dihapus.');
    }
}
