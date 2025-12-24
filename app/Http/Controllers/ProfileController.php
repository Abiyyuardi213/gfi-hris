<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'foto'     => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['password', 'foto']);

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        if ($request->hasFile('foto')) {
            // Delete old photo if exists? For now just overwrite
            $data['foto'] = $request->file('foto')->store('foto-user', 'public');
        }

        /** @var \App\Models\User $user */
        $user->updateUser($data);

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui.');
    }
}
