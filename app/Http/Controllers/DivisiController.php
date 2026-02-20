<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Kantor;
use Illuminate\Http\Request;

class DivisiController extends Controller
{
    public function index()
    {
        $divisis = Divisi::orderBy('created_at', 'asc')->get();

        return view('divisi.index', compact('divisis'));
    }

    public function create()
    {
        return view('divisi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_divisi' => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'status'      => 'required|boolean',
        ]);

        $divisi = Divisi::createDivisi($request->all());

        \App\Helpers\ActivityLogger::log('Create Divisi', 'Menambahkan divisi baru: ' . $divisi->nama_divisi);

        return redirect()
            ->route('divisi.index')
            ->with('success', 'Divisi berhasil ditambahkan.');
    }



    public function edit($id)
    {
        $divisi  = Divisi::findOrFail($id);

        return view('divisi.edit', compact('divisi'));
    }

    public function update(Request $request, $id)
    {
        $divisi = Divisi::findOrFail($id);

        $request->validate([
            'nama_divisi' => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'status'      => 'required|boolean',
        ]);

        $divisi->updateDivisi($request->all());

        \App\Helpers\ActivityLogger::log('Update Divisi', 'Memperbarui divisi: ' . $divisi->nama_divisi);

        return redirect()
            ->route('divisi.index')
            ->with('success', 'Divisi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $divisi = Divisi::findOrFail($id);
        $nama = $divisi->nama_divisi;
        $divisi->delete();

        \App\Helpers\ActivityLogger::log('Delete Divisi', 'Menghapus divisi: ' . $nama);

        return redirect()
            ->route('divisi.index')
            ->with('success', 'Divisi berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        try {
            $divisi = Divisi::findOrFail($id);
            $divisi->toggleStatus();

            \App\Helpers\ActivityLogger::log('Toggle Status Divisi', 'Mengubah status divisi: ' . $divisi->nama_divisi);

            return response()->json([
                'success' => true,
                'message' => 'Status divisi berhasil diperbarui.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status divisi.',
            ], 500);
        }
    }
}
