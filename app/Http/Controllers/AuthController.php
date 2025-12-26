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

        // Check manually to handle Status messages
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $attemptCreds = ['email' => $login, 'password' => $password]; // Don't check status yet
        } else {
            // ... NIP logic ...
            $pegawai = \App\Models\Pegawai::where('nip', $login)->with('user')->first();
            if ($pegawai && $pegawai->user) {
                $attemptCreds = ['email' => $pegawai->user->email, 'password' => $password];
            } else {
                return back()->with('error', 'NIP tidak ditemukan.');
            }
        }

        if (Auth::attempt($attemptCreds)) {
            $user = Auth::user();

            // 1. Check Role: Kandidat
            if ($user->role && $user->role->role_name == 'Kandidat') {
                // 2. Check Verification (Email) - handled by EnsureEmailIsVerified middleware usually, but let's check basic
                // 3. Check Status (Admin Approval)
                if ($user->status == false) {
                    Auth::logout();
                    return back()->with('error', 'Akun Anda sedang menunggu persetujuan Admin.');
                }

                $request->session()->regenerate();
                return redirect()->route('recruitment.dashboard');
            }

            // Standard User Check Status
            if ($user->status == false) {
                Auth::logout();
                return back()->with('error', 'Akun Non-Aktif.');
            }

            $request->session()->regenerate();
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
