<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\KoleksiBuku;
use App\Models\CategoryBook;
use App\Models\PeminjamBuku;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserDashboardController extends Controller
{
    public function home(Request $request)
    {
        $categories = CategoryBook::all();
        $search = $request->get('search');
        $searchCategory = $request->get('category');

        $books = KoleksiBuku::with('kategori')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('judul', 'LIKE', "%$search%")
                        ->orWhere('kode_buku', 'LIKE', "%$search%");
                });
            })
            ->when($searchCategory, function ($query) use ($searchCategory) {
                $query->where('kategori_id', $searchCategory);
            })
            ->get();

        return view('user.home.index', compact('books', 'categories', 'search', 'searchCategory'));
    }

    public function detail($id)
    {
        $book = KoleksiBuku::findOrFail($id);
        return view('user.detail.index', compact('book'));
    }

   
}
