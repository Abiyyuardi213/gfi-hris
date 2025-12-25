<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\Divisi;
use App\Models\Kantor;
use App\Models\RiwayatKarir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MutasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $riwayat = RiwayatKarir::with(['pegawai', 'jabatanAwal', 'jabatanTujuan'])->latest()->get();
        return view('mutasi.index', compact('riwayat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::with(['jabatan', 'divisi', 'kantor'])->orderBy('nama_lengkap')->get();
        $jabatans = Jabatan::all();
        $divisis = Divisi::all();
        $kantors = Kantor::all();

        return view('mutasi.create', compact('pegawais', 'jabatans', 'divisis', 'kantors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'jenis_perubahan' => 'required|in:Promosi,Mutasi,Demosi,Rotasi,Penyesuaian',
            'jabatan_tujuan_id' => 'required|exists:jabatans,id',
            'divisi_tujuan_id' => 'required|exists:divisis,id',
            'kantor_tujuan_id' => 'required|exists:kantors,id',
            'tanggal_efektif' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            $pegawai = Pegawai::findOrFail($request->pegawai_id);

            // Simpan Riwayat
            RiwayatKarir::create([
                'pegawai_id' => $pegawai->id,
                'jenis_perubahan' => $request->jenis_perubahan,

                // Data Lama
                'jabatan_awal_id' => $pegawai->jabatan_id,
                'divisi_awal_id' => $pegawai->divisi_id,
                'kantor_awal_id' => $pegawai->kantor_id,

                // Data Baru
                'jabatan_tujuan_id' => $request->jabatan_tujuan_id,
                'divisi_tujuan_id' => $request->divisi_tujuan_id,
                'kantor_tujuan_id' => $request->kantor_tujuan_id,

                'tanggal_efektif' => $request->tanggal_efektif,
                'no_sk' => $request->no_sk,
                'keterangan' => $request->keterangan,
                'dibuat_oleh' => Auth::id()
            ]);

            // Update Master Pegawai
            $pegawai->update([
                'jabatan_id' => $request->jabatan_tujuan_id,
                'divisi_id' => $request->divisi_tujuan_id,
                'kantor_id' => $request->kantor_tujuan_id,
            ]);

            DB::commit();
            return redirect()->route('mutasi.index')->with('success', 'Mutasi pegawai berhasil disimpan dan diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal memproses mutasi: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $riwayat = RiwayatKarir::with(['pegawai.jabatan', 'pegawai.divisi', 'creator', 'jabatanAwal', 'jabatanTujuan'])->findOrFail($id);
        return view('mutasi.show', compact('riwayat'));
    }
}
