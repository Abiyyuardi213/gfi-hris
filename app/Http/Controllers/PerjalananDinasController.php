<?php

namespace App\Http\Controllers;

use App\Models\PerjalananDinas;
use App\Models\Pegawai;
use App\Models\BiayaDinas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PerjalananDinasController extends Controller
{
    // === LIST ===
    public function index()
    {
        $user = Auth::user();
        $role = strtolower($user->role->role_name);

        if (in_array($role, ['super admin', 'admin'])) {
            // Admin sees all, with participants loaded
            $perjalananDinas = PerjalananDinas::with('peserta')->latest()->get();
        } else {
            // Pegawai sees only trips where they are a participant
            $pegawai = Pegawai::where('user_id', $user->id)->first();
            if (!$pegawai) abort(403);

            $perjalananDinas = PerjalananDinas::whereHas('peserta', function ($q) use ($pegawai) {
                $q->where('pegawai_id', $pegawai->id);
            })->with('peserta')->latest()->get();
        }

        return view('perjalanan-dinas.index', compact('perjalananDinas', 'role'));
    }

    // === CREATE ===
    public function create()
    {
        $user = Auth::user();
        $role = strtolower($user->role->role_name);
        $pegawais = [];

        if (in_array($role, ['super admin', 'admin'])) {
            // Admin can select any employee
            $pegawais = Pegawai::orderBy('nama_lengkap')->get();
        } else {
            // Regular user only submits for themselves (automatic)
        }

        return view('perjalanan-dinas.create', compact('pegawais', 'role'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $role = strtolower($user->role->role_name);
        $isAdmin = in_array($role, ['super admin', 'admin']);

        $pegawai = Pegawai::where('user_id', $user->id)->first();

        // Validation
        $rules = [
            'tujuan' => 'required',
            'keperluan' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jenis_transportasi' => 'required',
            'estimasi_biaya' => 'required|numeric',
        ];

        if ($isAdmin) {
            $rules['peserta_ids'] = 'required|array|min:1';
            $rules['peserta_ids.*'] = 'exists:pegawais,id';
        }

        $request->validate($rules);

        // Auto Generate No Surat
        $month = date('m');
        $year = date('Y');
        $count = PerjalananDinas::whereYear('created_at', $year)->count() + 1;
        $noSurat = "SPPD/{$year}/{$month}/" . str_pad($count, 3, '0', STR_PAD_LEFT);

        // Determine creator/primary contact (optional, can be null or the first participant)
        // We set 'pegawai_id' to the creator if they are an employee, or null/first participant.
        // If Admin creates, 'pegawai_id' could be the admin's employee record OR the first participant. 
        // Let's use the first participant as the "Lead".

        $primaryPegawaiId = $isAdmin ? $request->peserta_ids[0] : ($pegawai ? $pegawai->id : null);

        $perjalanan = PerjalananDinas::create([
            'pegawai_id' => $primaryPegawaiId, // Main contact
            'no_surat_tugas' => $noSurat,
            'tujuan' => $request->tujuan,
            'keperluan' => $request->keperluan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jenis_transportasi' => $request->jenis_transportasi,
            'estimasi_biaya' => $request->estimasi_biaya,
            'status' => 'Pengajuan',
        ]);

        // Attach Participants
        if ($isAdmin) {
            $perjalanan->peserta()->attach($request->peserta_ids);
        } else {
            // Pegawai attaches themselves
            if ($pegawai) {
                $perjalanan->peserta()->attach($pegawai->id);
            }
        }

        return redirect()->route('perjalanan-dinas.index')->with('success', 'Pengajuan perjalanan dinas berhasil dibuat.');
    }

    // === SHOW ===
    public function show($id)
    {
        $user = Auth::user();
        $role = strtolower($user->role->role_name);

        // Eager load peserta
        $perjalanan = PerjalananDinas::with(['peserta.jabatan', 'biayaDinas', 'approver'])->findOrFail($id);

        // Security Check: If Not Admin, ensure user is a participant
        if (!in_array($role, ['super admin', 'admin'])) {
            $pegawai = Pegawai::where('user_id', $user->id)->first();
            if (!$pegawai) abort(403);

            // Check existence in pivot
            $exists = $perjalanan->peserta->contains('id', $pegawai->id);
            if (!$exists) abort(403, 'Unauthorized access to this document.');
        }

        return view('perjalanan-dinas.show', compact('perjalanan', 'role'));
    }

    public function print($id)
    {
        $perjalanan = PerjalananDinas::with(['peserta.jabatan', 'approver'])->findOrFail($id);
        // Security checks if needed same as Show
        return view('perjalanan-dinas.print', compact('perjalanan'));
    }

    // === APPROVAL ===
    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $perjalanan = PerjalananDinas::findOrFail($id);
        $approver = Pegawai::where('user_id', $user->id)->first();

        $status = $request->action == 'reject' ? 'Ditolak' : 'Disetujui';

        $perjalanan->update([
            'status' => $status,
            'disetujui_oleh' => $approver ? $approver->id : null,
            'catatan_persetujuan' => $request->catatan,
        ]);

        return redirect()->back()->with('success', "Status berhasil diubah menjadi {$status}.");
    }

    // === REALIZATION (REPORTING) ===
    public function realization(Request $request, $id)
    {
        $perjalanan = PerjalananDinas::findOrFail($id);
        $perjalanan->update([
            'status' => 'Selesai',
            'realisasi_biaya' => $request->total_realisasi
        ]);

        return redirect()->back()->with('success', 'Laporan realisasi berhasil disimpan.');
    }
}
