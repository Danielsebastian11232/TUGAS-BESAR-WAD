<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryBook;
use App\Models\KoleksiBuku;
use App\Models\PeminjamBuku;
use Illuminate\Http\Request;

class KoleksiBukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        if ($search) {
            $books = KoleksiBuku::with('kategori')
                ->where('judul', 'LIKE', "%$search%")
                ->orWhere('kode_buku', 'LIKE', "%$search%")
                ->paginate(30);
        } else {
            $books = KoleksiBuku::with('kategori')
                ->paginate(30);
            $search = '';
        }
        $categories = CategoryBook::all();
        return view('admin.koleksiBuku.index', compact('books', 'categories', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'kode_buku' => 'required|unique:koleksi_buku,kode_buku',
            'kategori_id' => 'required|exists:kategori_buku,id',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|date',
            'cover' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'required',
            'stok_buku' => 'required|numeric',
        ]);

        $cover = $request->file('cover');
        $coverName = time() . '.' . $cover->extension();
        $cover->move(public_path('img/books/cover'), $coverName);

        KoleksiBuku::create([
            'judul' => $request->judul,
            'kode_buku' => $request->kode_buku,
            'kategori_id' => $request->kategori_id,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'cover' => $coverName,
            'deskripsi' => $request->deskripsi,
            'stok_buku' => $request->stok_buku,
        ]);

        return redirect()->route('admin.koleksi-buku.index')->with('success', 'Buku berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = KoleksiBuku::with('kategori')->findOrFail($id);

        $returned = request()->get('returned');
        if ($returned == '1') {
            $listOfBorrowers = PeminjamBuku::where('buku_id', $id)->where('returned', 1)->paginate(30);
        } else if ($returned == '0') {
            $listOfBorrowers = PeminjamBuku::where('buku_id', $id)->where('returned', 0)->paginate(30);
        } else {
            $listOfBorrowers = PeminjamBuku::where('buku_id', $id)->latest()->paginate(30);
            $returned = '';
        }

        return view('admin.koleksiBuku.detail', compact('book', 'listOfBorrowers', 'returned'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'judul' => 'required',
            'kode_buku' => 'required|unique:koleksi_buku,kode_buku,' . $id,
            'kategori_id' => 'required|exists:kategori_buku,id',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|date',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'required',
            'stok_buku' => 'required|numeric',
        ]);


        $book = KoleksiBuku::lockForUpdate()->findOrFail($id);

        if ($request->hasFile('cover')) {
            // delete old cover
            if ($book->cover) {
                unlink(public_path('img/books/cover/' . $book->cover));
            }
            $cover = $request->file('cover');
            $coverName = time() . '.' . $cover->extension();
            $cover->move(public_path('img/books/cover'), $coverName);
            $book->cover = $coverName;
        }

        $book->update([
            'judul' => $request->judul,
            'kode_buku' => $request->kode_buku,
            'kategori_id' => $request->kategori_id,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'deskripsi' => $request->deskripsi,
            'stok_buku' => $request->stok_buku,
        ]);

        return redirect()->route('admin.koleksi-buku.index')->with('success', 'Buku berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = KoleksiBuku::findOrFail($id);

        if ($book->cover) {
            unlink(public_path('img/books/cover/' . $book->cover));
        }

        $book->delete();

        return redirect()->route('admin.koleksi-buku.index')->with('success', 'Buku berhasil dihapus');
    }
}
