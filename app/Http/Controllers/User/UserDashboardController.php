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
        return view('user.home.index');
    }

   
}
