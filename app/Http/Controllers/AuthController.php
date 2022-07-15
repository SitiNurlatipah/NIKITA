<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {

        $request->validate([
            'nik' => 'required',
            'password' => 'required'
        ]);
        if (Auth::attempt($request->only('nik', 'password'))) {
            return redirect('dashboard');
        }
        return redirect('/')->with('failed', 'NIK atau Password salah!');
    }

    public function Register(Request $request)
    {
        return view('auth/register');
    }

    public function postregister(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'nik' => 'required',
            'password' => 'required'
        ]);
        $pengguna = User::create([
            'nama_pengguna' => $request->username,
            'nik' => $request->nik,
            'password' => bcrypt($request->password)
        ]);
        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }
}
