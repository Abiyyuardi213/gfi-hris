<?php

namespace App\Http\Controllers;

use App\Models\Lembur;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LemburController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Filter parameters
        $tanggal = $request->input('tanggal');
        $status = $request->input('status');

        $query = Lembur::with('pegawai');

        if (strtolower($user->role->role_name) == 'pegawai') {
            $pegawai = Pegawai::where('user_id', $user->id)->first();
            if ($pegawai) {
                $query->where('pegawai_id', $pegawai->id);
            } else {
                return redirect()->back()->with('error', 'Data pegawai tidak ditemukan.');
            }
        }

        if ($tanggal) {
            $query->whereDate('tanggal', $tanggal);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $lemburs = $query->latest()->get();

        return view('lembur.index', compact('lemburs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lembur.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $pegawai = Pegawai::where('user_id', $user->id)->first();

        if (!$pegawai) {
            return redirect()->back()->with('error', 'Data pegawai tidak ditemukan.');
        }

        $request->validate([
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'keterangan' => 'required|string',
        ]);

        Lembur::create([
            'pegawai_id' => $pegawai->id,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'keterangan' => $request->keterangan,
            'status' => 'Menunggu',
        ]);

        return redirect()->route('lembur.index')->with('success', 'Pengajuan lembur berhasil dikirim.');
    }

    // Admin Actions
    public function approve(Request $request, $id)
    {
        $lembur = Lembur::findOrFail($id);
        $lembur->update(['status' => 'Disetujui']);
        return redirect()->back()->with('success', 'Lembur disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $lembur = Lembur::findOrFail($id);
        $lembur->update([
            'status' => 'Ditolak',
            'catatan_approval' => $request->catatan_approval // Optional reason
        ]);
        return redirect()->back()->with('success', 'Lembur ditolak.');
    }

    public function destroy($id)
    {
        $lembur = Lembur::findOrFail($id);

        // Only allow deleting own Pending requests or Admin deleting any
        $user = Auth::user();
        if (strtolower($user->role->role_name) == 'pegawai') {
            if ($lembur->status != 'Menunggu') {
                return redirect()->back()->with('error', 'Tidak dapat menghapus data yang sudah diproses.');
            }
        }

        $lembur->delete();
        return redirect()->back()->with('success', 'Data lembur dihapus.');
    }
}
