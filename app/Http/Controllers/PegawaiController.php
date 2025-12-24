<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Kantor;
use App\Models\Divisi;
use App\Models\Jabatan;
use App\Models\StatusPegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawais = Pegawai::with(['kantor', 'divisi', 'jabatan', 'statusPegawai'])->latest()->get();
        return view('pegawai.index', compact('pegawais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kantors = Kantor::all();
        $divisis = Divisi::all();
        $jabatans = Jabatan::all();
        $statusPegawais = StatusPegawai::all();

        return view('pegawai.create', compact('kantors', 'divisis', 'jabatans', 'statusPegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|size:16|unique:pegawais,nik',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat_ktp' => 'nullable|string',
            'alamat_domisili' => 'nullable|string',
            'no_hp' => 'nullable|string|max:15',
            'email_pribadi' => 'nullable|email|max:255',
            'agama' => 'nullable|string',
            'status_pernikahan' => 'nullable|string',
            'tanggal_masuk' => 'required|date',
            'kantor_id' => 'required|exists:kantor,id',
            'divisi_id' => 'required|exists:divisi,id',
            'jabatan_id' => 'required|exists:jabatan,id',
            'status_pegawai_id' => 'required|exists:status_pegawai,id',
            'foto' => 'nullable|image|max:2048', // Max 2MB
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('foto-pegawai', 'public');
            $validated['foto'] = $path;
        }

        Pegawai::create($validated);

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pegawai $pegawai)
    {
        return view('pegawai.show', compact('pegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pegawai $pegawai)
    {
        $kantors = Kantor::all();
        $divisis = Divisi::all();
        $jabatans = Jabatan::all();
        $statusPegawais = StatusPegawai::all();

        return view('pegawai.edit', compact('pegawai', 'kantors', 'divisis', 'jabatans', 'statusPegawais'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|size:16|unique:pegawais,nik,' . $pegawai->id,
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat_ktp' => 'nullable|string',
            'alamat_domisili' => 'nullable|string',
            'no_hp' => 'nullable|string|max:15',
            'email_pribadi' => 'nullable|email|max:255',
            'agama' => 'nullable|string',
            'status_pernikahan' => 'nullable|string',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'nullable|date',
            'kantor_id' => 'required|exists:kantor,id',
            'divisi_id' => 'required|exists:divisi,id',
            'jabatan_id' => 'required|exists:jabatan,id',
            'status_pegawai_id' => 'required|exists:status_pegawai,id',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // Delete old photo if exists? For now just overwrite reference
            $path = $request->file('foto')->store('foto-pegawai', 'public');
            $validated['foto'] = $path;
        }

        $pegawai->update($validated);

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();
        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil dihapus.');
    }
}
