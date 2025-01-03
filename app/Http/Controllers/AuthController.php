<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        $credentials['is_deleted'] = false; //untuk ngecek apakah usernya masih ada atau sudah dihapus

        if (auth()->attempt($credentials)) {
            session()->regenerate();
            if (auth()->user()->is_admin) {
                return redirect()->route('admin.koleksi-buku.index');
            } else {
                return redirect()->route('home');
            }
        }

        return back()->with('error', 'Email atau password salah');
    }

    public function postRegister(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|numeric',
            'date_of_birth' => 'required|date',
            'password' => 'required|min:3',
            'password_confirmation' => 'required|same:password'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->date_of_birth = $request->date_of_birth;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silahkan login');
    }

    public function logout()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login');
    }

}
