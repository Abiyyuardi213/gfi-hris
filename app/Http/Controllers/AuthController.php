<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required'
        ]);

        $login = $request->input('login');
        $password = $request->input('password');

        $credentials = [];

        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $credentials = ['email' => $login, 'password' => $password, 'status' => true];
        } else {
            // Assume NIP, find Pegawai
            $pegawai = \App\Models\Pegawai::where('nip', $login)->with('user')->first();
            if ($pegawai && $pegawai->user) {
                // We use the email of the user associated with this Pegawai
                $credentials = ['email' => $pegawai->user->email, 'password' => $password, 'status' => true];
            } else {
                return back()->withErrors([
                    'login' => 'NIP tidak ditemukan atau tidak terdaftar sebagai user aktif.',
                ])->onlyInput('login');
            }
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect based on role
            // if (Auth::user()->role->role_name == 'Pegawai') {
            //    return redirect()->route('dashboard.pegawai');
            // }

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'login' => 'Login gagal. Periksa kembali NIP/Email dan Password anda.',
        ])->onlyInput('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
