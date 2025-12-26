<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerificationController extends Controller
{
    public function notice()
    {
        return view('auth.verify');
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        // Redirect based on role
        if ($request->user()->role->role_name == 'Kandidat') {
            return redirect()->route('recruitment.dashboard')->with('success', 'Email berhasil diverifikasi.');
        }
        return redirect()->route('dashboard');
    }

    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Link verifikasi telah dikirim ulang!');
    }
}
