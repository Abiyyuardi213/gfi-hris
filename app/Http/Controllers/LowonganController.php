<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use Illuminate\Http\Request;

class LowonganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lowongans = Lowongan::latest()->get();
        return view('recruitment.admin.lowongan.index', compact('lowongans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('recruitment.admin.lowongan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tipe_pekerjaan' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        Lowongan::create($request->all());

        return redirect()->route('lowongan.index')->with('success', 'Lowongan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lowongan $lowongan)
    {
        return view('recruitment.admin.lowongan.show', compact('lowongan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lowongan $lowongan)
    {
        return view('recruitment.admin.lowongan.edit', compact('lowongan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lowongan $lowongan)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tipe_pekerjaan' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $lowongan->update($request->all());

        return redirect()->route('lowongan.index')->with('success', 'Lowongan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lowongan $lowongan)
    {
        $lowongan->delete();
        return redirect()->route('lowongan.index')->with('success', 'Lowongan berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        $lowongan = Lowongan::findOrFail($id);
        $lowongan->is_active = !$lowongan->is_active;
        $lowongan->save();

        return response()->json(['success' => true, 'message' => 'Status lowongan diperbarui.']);
    }
}
