<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Divisi;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatans = Jabatan::with('divisi.kantor')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('jabatan.index', compact('jabatans'));
    }

    public function create()
    {
        $divisis = Divisi::where('status', true)
            ->with('kantor')
            ->get();

        return view('jabatan.create', compact('divisis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'divisi_id'    => 'required|exists:divisi,id',
            'nama_jabatan' => 'required|string|max:255',
            'deskripsi'    => 'nullable|string',
            'status'       => 'required|boolean',
        ]);

        Jabatan::createJabatan($request->all());

        return redirect()
            ->route('jabatan.index')
            ->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $jabatan = Jabatan::with('divisi.kantor')
            ->findOrFail($id);

        return view('jabatan.show', compact('jabatan'));
    }

    public function edit($id)
    {
        $jabatan = Jabatan::findOrFail($id);

        $divisis = Divisi::where('status', true)
            ->with('kantor')
            ->orderBy('nama_divisi')
            ->get();

        return view('jabatan.edit', compact('jabatan', 'divisis'));
    }

    public function update(Request $request, $id)
    {
        $jabatan = Jabatan::findOrFail($id);

        $request->validate([
            'divisi_id'    => 'required|exists:divisi,id',
            'nama_jabatan' => 'required|string|max:255',
            'deskripsi'    => 'nullable|string',
            'status'       => 'required|boolean',
        ]);

        $jabatan->updateJabatan($request->all());

        return redirect()
            ->route('jabatan.index')
            ->with('success', 'Jabatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->delete();

        return redirect()
            ->route('jabatan.index')
            ->with('success', 'Jabatan berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        try {
            $jabatan = Jabatan::findOrFail($id);
            $jabatan->toggleStatus();

            return response()->json([
                'success' => true,
                'message' => 'Status jabatan berhasil diperbarui.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status jabatan.',
            ], 500);
        }
    }
}
