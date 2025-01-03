<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryBook;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        if ($search) {
            $categories = CategoryBook::where('nama_kategori', 'LIKE', "%$search%")->paginate(30);
        } else {
            $categories = CategoryBook::paginate(30);
            $search = '';
        }
        return view('admin.kategori.index', compact('categories', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required'
        ]);

        CategoryBook::create($request->all());

        return redirect()->route('admin.category.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
            'nama_kategori' => 'required'
        ]);

        $category = CategoryBook::findOrFail($id);

        $category->update($request->all());

        return redirect()->route('admin.category.index')->with('success', 'Kategori berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = CategoryBook::findOrFail($id);


        $category->delete();

        return redirect()->route('admin.category.index')->with('success', 'Kategori berhasil dihapus');
    }
}
