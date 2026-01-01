<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Kandidat;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;

class RecruitmentAuthController extends Controller
{
    public function showLink()
    {
        // Just a landing page or redirect to register
        return redirect()->route('recruitment.register');
    }

    public function showLogin()
    {
        return view('recruitment.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Custom attempt manually to check specific role conditions BEFORE Auth::login
        // actually Auth::attempt does it automatically. We just need to check after.

        if (Auth::attempt($credentials, $request->remember)) {
            $user = Auth::user();

            // Check Role
            if ($user->role->role_name !== 'Kandidat') {
                Auth::logout();
                return back()->with('error', 'Halaman ini khusus untuk Pelamar/Kandidat. Pegawai silakan login di halaman utama.');
            }

            // Check Status (Admin Approval)
            if (!$user->status) {
                Auth::logout();
                return back()->with('success', 'Login Berhasil, namun Akun Anda masih menunggu persetujuan Admin.');
                // Or use 'error' but text says success? Let's use warning/error context.
                // Actually 'error' acts as flash message in the view I made.
                // Let's stick to error for the user experience "I can't get in".
                // return back()->with('error', 'Akun Anda sedang dalam proses verifikasi Admin. Silakan tunggu notifikasi via email.');
            }

            $request->session()->regenerate();
            return redirect()->intended(route('recruitment.dashboard'));
        }

        return back()->with('error', 'Email atau Password salah.');
    }

    public function showRegister()
    {
        return view('recruitment.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::beginTransaction();
        try {
            // 1. Get Role
            $role = Role::where('role_name', 'Kandidat')->first();
            if (!$role) {
                throw new \Exception('Role Kandidat belum tersedia. Hubungi Admin.');
            }

            // 2. Create User (Status False -> Waiting Admin Approval)
            $user = User::create([
                'id' => (string) Str::uuid(),
                'name' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $role->id,
                'status' => false, // Pending Admin Approval
            ]);

            // 3. Create Kandidat Profile (Initial Empty)
            Kandidat::create([
                'user_id' => $user->id,
                'status_lamaran' => 'Baru'
            ]);

            // 4. Notify Admins (Realtime Poll)
            $adminRoleIds = Role::whereIn('role_name', ['Super Admin', 'Admin'])->pluck('id');
            $admins = User::whereIn('role_id', $adminRoleIds)->get();
            foreach ($admins as $admin) {
                $admin->notify(new \App\Notifications\NewCandidateNotification($user));
            }

            DB::commit();

            return redirect()->route('recruitment.login')->with('success', 'Registrasi berhasil! Akun Anda sedang menunggu verifikasi Admin. Silakan cek secara berkala.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Registrasi gagal: ' . $e->getMessage())->withInput();
        }
    }

    public function dashboard()
    {
        $user = Auth::user();
        $kandidat = Kandidat::where('user_id', $user->id)->first();

        if (!$kandidat) {
            $kandidat = Kandidat::create([
                'user_id' => $user->id,
                'status_lamaran' => 'Baru'
            ]);
        }

        // Check recent applications
        $lamarans = \App\Models\Lamaran::where('kandidat_id', $kandidat->id)->with(['lowongan', 'wawancaras'])->latest()->get();
        return view('recruitment.dashboard', compact('user', 'kandidat', 'lamarans'));
    }

    public function showApplicationDetail($id)
    {
        $user = Auth::user();
        $kandidat = Kandidat::where('user_id', $user->id)->firstOrFail();

        $lamaran = \App\Models\Lamaran::where('id', $id)
            ->where('kandidat_id', $kandidat->id)
            ->with(['lowongan', 'wawancaras'])
            ->firstOrFail();

        return view('recruitment.application.detail', compact('lamaran'));
    }

    public function showProfile()
    {
        $user = Auth::user();
        $kandidat = Kandidat::where('user_id', $user->id)->first();
        return view('recruitment.profile', compact('user', 'kandidat'));
    }

    public function vacancyList()
    {
        $lowongans = \App\Models\Lowongan::where('is_active', true)
            ->where('tanggal_akhir', '>=', now())
            ->latest()
            ->get();
        return view('recruitment.vacancy.index', compact('lowongans'));
    }

    public function showVacancy($id)
    {
        $lowongan = \App\Models\Lowongan::with('lamarans')->findOrFail($id);

        // Check if already applied
        $user = Auth::user();
        $kandidat = Kandidat::where('user_id', $user->id)->first();
        $hasApplied = false;
        if ($kandidat) {
            $hasApplied = \App\Models\Lamaran::where('lowongan_id', $id)
                ->where('kandidat_id', $kandidat->id)
                ->exists();
        }

        return view('recruitment.vacancy.show', compact('lowongan', 'hasApplied'));
    }

    public function applyVacancy($id)
    {
        $user = Auth::user();
        $kandidat = Kandidat::where('user_id', $user->id)->first();

        // Validate Profile Completeness??
        if (!$kandidat->nik || !$kandidat->no_hp || !$kandidat->file_cv) {
            return redirect()->route('recruitment.profile')->with('error', 'Silakan lengkapi profil dan upload CV terlebih dahulu sebelum melamar.');
        }

        // Check duplicate
        $exists = \App\Models\Lamaran::where('lowongan_id', $id)
            ->where('kandidat_id', $kandidat->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Anda sudah melamar posisi ini.');
        }

        \App\Models\Lamaran::create([
            'lowongan_id' => $id,
            'kandidat_id' => $kandidat->id,
            'status' => 'Pending'
        ]);

        return redirect()->route('recruitment.dashboard')->with('success', 'Lamaran berhasil dikirim! Pantau status lamaran Anda di Dashboard.');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        // ... (existing logic) rest of the function remains same but needs to be included in replacement if I replace the block.
        $kandidat = Kandidat::where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'nik' => 'required|numeric',
            'no_hp' => 'required',
            'alamat' => 'required|string',
            'pendidikan_terakhir' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'foto' => 'nullable|image|max:2048',
            'scan_ktp' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'ijazah' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'transkrip' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'cv' => 'nullable|mimes:pdf|max:2048',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('kandidat/foto', 'public');
                $user->update(['foto' => $fotoPath]);
                $kandidat->update(['file_foto' => $fotoPath]);
            }

            $dataToUpdate = [
                'nik' => $request->nik,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
            ];

            if ($request->hasFile('scan_ktp')) $dataToUpdate['file_ktp'] = $request->file('scan_ktp')->store('kandidat/docs', 'public');
            if ($request->hasFile('ijazah')) $dataToUpdate['file_ijazah'] = $request->file('ijazah')->store('kandidat/docs', 'public');
            if ($request->hasFile('transkrip')) $dataToUpdate['file_transkrip'] = $request->file('transkrip')->store('kandidat/docs', 'public');
            if ($request->hasFile('cv')) $dataToUpdate['file_cv'] = $request->file('cv')->store('kandidat/docs', 'public');

            $kandidat->update($dataToUpdate);

            DB::commit();
            return back()->with('success', 'Data profil berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
    }
}
