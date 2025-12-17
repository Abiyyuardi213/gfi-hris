<?php

namespace App\Http\Controllers;

use App\Models\DivisiJabatan;
use App\Models\Divisi;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class DivisiJabatanController extends Controller
{
    public function index()
    {
        $divisiJabatans = DivisiJabatan::with([
                'divisi.kantor',
                'jabatan'
            ])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('divisi_jabatan.index', compact('divisiJabatans'));
    }

    public function create()
    {
        $divisis  = Divisi::where('status', true)->with('kantor')->get();
        $jabatans = Jabatan::where('status', true)->get();

        return view('divisi_jabatan.create', compact('divisis', 'jabatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'divisi_id'  => 'required|exists:divisi,id',
            'jabatan_id' => 'required|exists:jabatan,id',
            'status'     => 'required|boolean',
        ]);

        $exists = DivisiJabatan::where('divisi_id', $request->divisi_id)
            ->where('jabatan_id', $request->jabatan_id)
            ->exists();

        if ($exists) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Kombinasi Divisi dan Jabatan sudah ada.');
        }

        DivisiJabatan::createDivisiJabatan($request->all());

        return redirect()
            ->route('divisi-jabatan.index')
            ->with('success', 'Divisi Jabatan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $divisiJabatan = DivisiJabatan::with([
                'divisi.kantor',
                'jabatan'
            ])
            ->findOrFail($id);

        return view('divisi_jabatan.show', compact('divisiJabatan'));
    }

    public function edit($id)
    {
        $divisiJabatan = DivisiJabatan::findOrFail($id);
        $divisis       = Divisi::where('status', true)->with('kantor')->get();
        $jabatans      = Jabatan::where('status', true)->get();

        return view('divisi_jabatan.edit', compact(
            'divisiJabatan',
            'divisis',
            'jabatans'
        ));
    }

    public function update(Request $request, $id)
    {
        $divisiJabatan = DivisiJabatan::findOrFail($id);

        $request->validate([
            'divisi_id'  => 'required|exists:divisi,id',
            'jabatan_id' => 'required|exists:jabatan,id',
            'status'     => 'required|boolean',
        ]);

        $exists = DivisiJabatan::where('divisi_id', $request->divisi_id)
            ->where('jabatan_id', $request->jabatan_id)
            ->where('id', '!=', $divisiJabatan->id)
            ->exists();

        if ($exists) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Kombinasi Divisi dan Jabatan sudah ada.');
        }

        $divisiJabatan->updateDivisiJabatan($request->all());

        return redirect()
            ->route('divisi-jabatan.index')
            ->with('success', 'Divisi Jabatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $divisiJabatan = DivisiJabatan::findOrFail($id);
        $divisiJabatan->delete();

        return redirect()
            ->route('divisi-jabatan.index')
            ->with('success', 'Divisi Jabatan berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        try {
            $divisiJabatan = DivisiJabatan::findOrFail($id);
            $divisiJabatan->toggleStatus();

            return response()->json([
                'success' => true,
                'message' => 'Status Divisi Jabatan berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status.'
            ], 500);
        }
    }
}
