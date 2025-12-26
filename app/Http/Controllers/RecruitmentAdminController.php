<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kandidat;
use App\Models\Role; // Added Import

class RecruitmentAdminController extends Controller
{
    public function index()
    {
        // List pending candidates (User status false, Role Kandidat)
        $role = Role::where('role_name', 'Kandidat')->first();
        if (!$role) return back();

        $kandidats = Kandidat::whereHas('user', function ($q) use ($role) {
            $q->where('role_id', $role->id)->orderBy('created_at', 'desc');
        })->with('user')->get();

        return view('recruitment.admin.index', compact('kandidats'));
    }

    public function show($id)
    {
        $kandidat = Kandidat::with('user')->findOrFail($id);
        return view('recruitment.admin.show', compact('kandidat'));
    }

    public function approve($id)
    {
        $kandidat = Kandidat::findOrFail($id);
        if ($kandidat->user) {
            $kandidat->user->status = true; // Approve
            $kandidat->user->save();

            // Optional: Send email "Account Approved"
        }

        return redirect()->back()->with('success', 'Akun kandidat berhasil disetujui.');
    }

    public function reject($id)
    {
        // Soft delete user or just leave status false?
        // Let's just leave status false or delete.
        // For security, maybe delete or ban.
        $kandidat = Kandidat::findOrFail($id);
        // $kandidat->user->delete(); // Optional

        return redirect()->back()->with('success', 'Akun kandidat ditolak/dihapus.');
    }
}
