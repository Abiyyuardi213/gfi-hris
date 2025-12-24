<?php

namespace App\Http\Controllers;

use App\Models\PengajuanIzin;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengajuanIzinController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role->role_name == 'Super Admin' || $user->role->role_name == 'Admin') { // Adjust role check based on strict string or ID
            $izins = PengajuanIzin::with('pegawai')->orderBy('created_at', 'desc')->get();
        } else {
            // Pegawai only sees their own
            $pegawai = Pegawai::where('user_id', $user->id)->first();
            if ($pegawai) {
                $izins = PengajuanIzin::with('pegawai')
                    ->where('pegawai_id', $pegawai->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                $izins = collect();
            }
        }

        return view('pengajuan-izin.index', compact('izins'));
    }

    public function create()
    {
        return view('pengajuan-izin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_izin' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'required',
            'bukti_foto' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();
        $pegawai = Pegawai::where('user_id', $user->id)->first();

        if (!$pegawai) {
            return redirect()->back()->with('error', 'Data pegawai tidak ditemukan.');
        }

        $buktiPath = null;
        if ($request->hasFile('bukti_foto')) {
            $buktiPath = $request->file('bukti_foto')->store('izin-sakit', 'public');
        }

        PengajuanIzin::create([
            'pegawai_id' => $pegawai->id,
            'jenis_izin' => $request->jenis_izin,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keterangan' => $request->keterangan,
            'bukti_foto' => $buktiPath,
            'status_approval' => 'Pending',
        ]);

        return redirect()->route('pengajuan-izin.index')->with('success', 'Pengajuan berhasil dikirim.');
    }

    public function approve($id)
    {
        // Only Admin should access this
        $izin = PengajuanIzin::findOrFail($id);
        $izin->update([
            'status_approval' => 'Disetujui',
            'approved_by' => Auth::id(),
            'catatan_approval' => 'Disetujui oleh admin',
        ]);

        // Logic insert to Presensi table for these dates?
        // To be real HRIS, we should insert Presensi records status 'Izin'/'Sakit' for the range.
        // I will implement this simply.

        $start = \Carbon\Carbon::parse($izin->tanggal_mulai);
        $end = \Carbon\Carbon::parse($izin->tanggal_selesai);

        while ($start->lte($end)) {
            // Create presensi record if not exists
            \App\Models\Presensi::updateOrCreate(
                [
                    'pegawai_id' => $izin->pegawai_id,
                    'tanggal' => $start->format('Y-m-d'),
                ],
                [
                    'status' => $izin->jenis_izin,
                    'keterangan' => $izin->keterangan
                ]
            );
            $start->addDay();
        }

        return redirect()->back()->with('success', 'Pengajuan disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $izin = PengajuanIzin::findOrFail($id);
        $izin->update([
            'status_approval' => 'Ditolak',
            'approved_by' => Auth::id(),
            'catatan_approval' => $request->input('catatan', 'Ditolak oleh admin'),
        ]);

        return redirect()->back()->with('success', 'Pengajuan ditolak.');
    }
}
