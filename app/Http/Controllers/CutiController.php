<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\JenisCuti;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Cuti::with(['pegawai', 'jenisCuti']);

        // Check Role
        if (strtolower($user->role->role_name) == 'pegawai') {
            $pegawai = Pegawai::where('user_id', $user->id)->first();
            if ($pegawai) {
                $query->where('pegawai_id', $pegawai->id);
            } else {
                return redirect()->back()->with('error', 'Data pegawai tidak ditemukan.');
            }
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_mulai', $request->tanggal);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $cutis = $query->latest()->get();

        return view('cuti.index', compact('cutis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenisCutis = JenisCuti::all();
        $user = Auth::user();
        $pegawai = Pegawai::where('user_id', $user->id)->first();

        return view('cuti.create', compact('jenisCutis', 'pegawai'));
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
            'jenis_cuti_id' => 'required|exists:jenis_cutis,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'required|string',
        ]);

        $start = Carbon::parse($request->tanggal_mulai);
        $end = Carbon::parse($request->tanggal_selesai);
        $days = $start->diffInDays($end) + 1; // Inclusive

        // Check Quota if "Cuti Tahunan" or logic specific?
        // Usually we check if $pegawai->sisa_cuti >= $days if it consumes quota.
        // Let's assume all cutis consume quota for now or check JenisCuti logic usually.
        // For MVP, if it consumes quota (e.g. not 'Sakit' or 'Unpaid'), check balance.
        // Let's check generally if sisa_cuti enough.

        if ($pegawai->sisa_cuti < $days) {
            return redirect()->back()->with('error', 'Sisa cuti tidak mencukupi (Sisa: ' . $pegawai->sisa_cuti . ' hari, Pengajuan: ' . $days . ' hari).')->withInput();
        }

        Cuti::create([
            'pegawai_id' => $pegawai->id,
            'jenis_cuti_id' => $request->jenis_cuti_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'lama_hari' => $days,
            'keterangan' => $request->keterangan,
            'status' => 'Menunggu',
        ]);

        return redirect()->route('cuti.index')->with('success', 'Pengajuan cuti berhasil dikirim.');
    }

    // Admin Actions
    public function approve(Request $request, $id)
    {
        $cuti = Cuti::findOrFail($id);

        if ($cuti->status != 'Menunggu') {
            return redirect()->back()->with('error', 'Cuti sudah diproses sebelumnya.');
        }

        DB::beginTransaction();
        try {
            $pegawai = Pegawai::findOrFail($cuti->pegawai_id);

            // Deduct quota
            if ($pegawai->sisa_cuti >= $cuti->lama_hari) {
                $pegawai->decrement('sisa_cuti', $cuti->lama_hari);
            } else {
                throw new \Exception("Sisa cuti pegawai tidak mencukupi saat proses approval.");
            }

            $cuti->update([
                'status' => 'Disetujui',
                'approved_by' => Auth::id()
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Cuti disetujui dan kuota dikurangi.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal memproses approval: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $cuti = Cuti::findOrFail($id);
        if ($cuti->status != 'Menunggu') {
            return redirect()->back()->with('error', 'Cuti sudah diproses sebelumnya.');
        }

        $cuti->update([
            'status' => 'Ditolak',
            'catatan_approval' => $request->catatan_approval,
            'approved_by' => Auth::id()
        ]);
        return redirect()->back()->with('success', 'Cuti ditolak.');
    }

    public function destroy($id)
    {
        $cuti = Cuti::findOrFail($id);

        $user = Auth::user();
        if (strtolower($user->role->role_name) == 'pegawai') {
            if ($cuti->status != 'Menunggu') {
                return redirect()->back()->with('error', 'Tidak dapat menghapus data yang sudah diproses.');
            }
        }

        $cuti->delete();
        return redirect()->back()->with('success', 'Data cuti dihapus.');
    }
}
