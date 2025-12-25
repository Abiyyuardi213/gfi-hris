<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\Pegawai;
use App\Models\ShiftKerja;
use App\Models\HariLibur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     * Accessible by Admin/HRD to see all attendance.
     */
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal', date('Y-m-d'));

        // Optimize Eager Loading
        $presensis = Presensi::with(['pegawai.jabatan', 'pegawai.divisi', 'shiftKerja', 'pegawai.shiftKerja'])
            ->whereDate('tanggal', $tanggal)
            ->get();

        return view('presensi.index', compact('presensis', 'tanggal'));
    }

    /**
     * Show the form for check-in/check-out.
     * Accessible by regular Pegawai.
     */
    public function create()
    {
        $user = Auth::user();
        $pegawai = Pegawai::where('user_id', $user->id)->first();

        if (!$pegawai) {
            return redirect()->route('dashboard')->with('error', 'Akun anda tidak terhubung dengan data pegawai.');
        }

        $today = Carbon::now()->format('Y-m-d');
        $presensi = Presensi::where('pegawai_id', $pegawai->id)
            ->whereDate('tanggal', $today)
            ->first();

        // Check if today is holiday?
        $hariLibur = HariLibur::whereDate('tanggal', $today)->first();

        return view('presensi.create', compact('pegawai', 'presensi', 'hariLibur'));
    }

    /**
     * Store logic for Check In
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $pegawai = Pegawai::where('user_id', $user->id)->with('shiftKerja')->first();

        if (!$pegawai) {
            return response()->json(['success' => false, 'message' => 'Pegawai not found.']);
        }

        $request->validate([
            'foto' => 'required', // Base64 or uploaded file
            'lokasi' => 'required', // Lat,Long
        ]);

        $timezone = 'Asia/Jakarta';
        $now = Carbon::now($timezone);
        $today = $now->format('Y-m-d');

        // Check if already checked in
        $presensi = Presensi::where('pegawai_id', $pegawai->id)
            ->whereDate('tanggal', $today)
            ->first();

        if ($presensi && $presensi->jam_masuk) {
            return response()->json(['success' => false, 'message' => 'Anda sudah melakukan absen masuk hari ini.']);
        }

        // Get Shift info (from Pegawai relation)
        $shift = $pegawai->shiftKerja;

        // Fallback: If no shift assigned, use the first available shift
        if (!$shift) {
            $shift = ShiftKerja::first();
        }

        // Calculate Lateness
        $terlambat = 0;
        if ($shift) {
            $jamMasukShift = Carbon::parse($today . ' ' . $shift->jam_masuk, $timezone);

            // Debugging / Safety check
            // If checking in before shift starts, it's not late.
            // If checking in after, calculate diff.

            if ($now->gt($jamMasukShift)) {
                $terlambat = (int) $now->diffInMinutes($jamMasukShift);
            }
        }

        // Process Image
        $image = $request->foto; // Base64 string usually "data:image/png;base64,....."
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace('data:image/jpeg;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = 'presensi/masuk/' . $pegawai->nip . '-' . $today . '-' . time() . '.png';

        Storage::disk('public')->put($imageName, base64_decode($image));

        // Create or Update Presensi record
        // It helps if the record was pre-created by a nightly job with 'Alpa', allowing us to update it.
        // But for MVP, we create it now.

        $data = [
            'pegawai_id' => $pegawai->id,
            'shift_kerja_id' => $shift ? $shift->id : null,
            'tanggal' => $today,
            'jam_masuk' => $now->format('H:i:s'),
            'foto_masuk' => $imageName,
            'lokasi_masuk' => $request->lokasi,
            'status' => 'Hadir',
            'terlambat' => $terlambat,
        ];

        if ($presensi) {
            $presensi->update($data);
        } else {
            Presensi::create($data);
        }

        return response()->json(['success' => true, 'message' => 'Absen Masuk Berhasil!']);
    }

    /**
     * Update logic for Check Out
     */
    public function checkOut(Request $request)
    {
        $user = Auth::user();
        $pegawai = Pegawai::where('user_id', $user->id)->first();

        if (!$pegawai) {
            return response()->json(['success' => false, 'message' => 'Pegawai not found.']);
        }

        $request->validate([
            'foto' => 'required',
            'lokasi' => 'required',
        ]);

        $timezone = 'Asia/Jakarta';
        $now = Carbon::now($timezone);
        $today = $now->format('Y-m-d');

        $presensi = Presensi::where('pegawai_id', $pegawai->id)
            ->whereDate('tanggal', $today)
            ->first();

        if (!$presensi) {
            return response()->json(['success' => false, 'message' => 'Anda belum absen masuk hari ini.']);
        }

        if ($presensi->jam_pulang) {
            return response()->json(['success' => false, 'message' => 'Anda sudah melakukan absen pulang hari ini.']);
        }

        // Calculate Early Leave
        $pulangCepat = 0;
        $shift = $presensi->shiftKerja; // Use saved shift or current shift
        if ($shift) {
            $jamPulangShift = Carbon::parse($today . ' ' . $shift->jam_keluar, $timezone);
            if ($now->lt($jamPulangShift)) {
                $pulangCepat = $jamPulangShift->diffInMinutes($now);
            }
        }

        // Process Image
        $image = $request->foto;
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace('data:image/jpeg;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = 'presensi/pulang/' . $pegawai->nip . '-' . $today . '-' . time() . '.png';

        Storage::disk('public')->put($imageName, base64_decode($image));

        $presensi->update([
            'jam_pulang' => $now->format('H:i:s'),
            'foto_pulang' => $imageName,
            'lokasi_pulang' => $request->lokasi,
            'pulang_cepat' => $pulangCepat,
        ]);

        return response()->json(['success' => true, 'message' => 'Absen Pulang Berhasil!']);
    }

    /**
     * Update Presensi (Admin Validation)
     */
    public function update(Request $request, $id)
    {
        // Check role (case-insensitive) to be safe, though middleware handles it.
        $roleName = strtolower(Auth::user()->role->role_name);
        if ($roleName != 'super admin' && $roleName != 'admin') {
            return redirect()->back()->with('error', 'Unauthorized.');
        }

        $presensi = Presensi::findOrFail($id);

        $request->validate([
            'status' => 'required',
        ]);

        $data = [
            'status' => $request->status,
            'jam_masuk' => $request->jam_masuk, // Format 'H:i' from input type=time is fine, simpler than full datetime for now
            'jam_pulang' => $request->jam_pulang,
            'keterangan' => $request->keterangan,
        ];

        // Recalculate Terlambat/Pulang Cepat if needed?
        // For manual validation/override, usually the admin manually sets things or we trust the status.
        // But if they change 'jam_masuk', we could recalculate 'terlambat'.
        // Let's simple update for now, as Admin "Validation" often implies overriding calculated values.

        // Recalculate Terlambat
        if ($request->jam_masuk) {
            $shift = $presensi->shiftKerja;

            // If Presensi has no Shift recorded, try fetching from Pegawai
            if (!$shift) {
                $shift = $presensi->pegawai->shiftKerja;
                if ($shift) {
                    $data['shift_kerja_id'] = $shift->id; // Assign shift to presensi
                }
            }

            if ($shift) {
                $timezone = 'Asia/Jakarta';
                // Assume jam_masuk from input is H:i
                // And shift jam_masuk is H:i:s or H:i
                $jamMasukInput = \Carbon\Carbon::parse($presensi->tanggal->format('Y-m-d') . ' ' . $request->jam_masuk, $timezone);
                $jamMasukShift = \Carbon\Carbon::parse($presensi->tanggal->format('Y-m-d') . ' ' . $shift->jam_masuk, $timezone);

                if ($jamMasukInput->gt($jamMasukShift)) {
                    $data['terlambat'] = (int) $jamMasukInput->diffInMinutes($jamMasukShift);
                } else {
                    $data['terlambat'] = 0;
                }
            }
        }

        $presensi->update($data);

        return redirect()->back()->with('success', 'Data presensi berhasil diperbarui.');
    }

    /**
     * Monthly Summary View for Admin or Personal
     */
    public function summary(Request $request)
    {
        $currentMonth = $request->input('month', date('m'));
        $currentYear = $request->input('year', date('Y'));

        // If Admin, show all? Or list of pegawais with stats?
        // Let's make it a general attendance report.
        // For simplicity, let's view Personal Summary first if simple user.

        $user = Auth::user();

        if ($user->role->role_name == 'Pegawai') {
            $pegawais = Pegawai::where('user_id', $user->id)->with(['jabatan', 'divisi'])->get();
        } else {
            $pegawais = Pegawai::with(['jabatan', 'divisi'])->orderBy('nama_lengkap')->get();
        }

        // This can be heavy. Ideally, we just fetch aggregated data.
        return view('presensi.summary', compact('pegawais', 'currentMonth', 'currentYear'));
    }
}
