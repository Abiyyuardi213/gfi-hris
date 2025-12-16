<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Kantor;
use Illuminate\Http\Request;

class DivisiController extends Controller
{
    public function index()
    {
        $divisis = Divisi::with('kantor')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('divisi.index', compact('divisis'));
    }

    public function create()
    {
        $kantors = Kantor::where('status', true)->get();

        return view('divisi.create', compact('kantors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kantor_id'   => 'required|exists:kantor,id',
            'nama_divisi' => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'status'      => 'required|boolean',
        ]);

        Divisi::createDivisi($request->all());

        return redirect()
            ->route('divisi.index')
            ->with('success', 'Divisi berhasil ditambahkan.');
    }

    public function show($id)
    {
        $divisi = Divisi::with('kantor')->findOrFail($id);

        return view('divisi.show', compact('divisi'));
    }

    public function edit($id)
    {
        $divisi  = Divisi::findOrFail($id);
        $kantors = Kantor::where('status', true)->get();

        return view('divisi.edit', compact('divisi', 'kantors'));
    }

    public function update(Request $request, $id)
    {
        $divisi = Divisi::findOrFail($id);

        $request->validate([
            'kantor_id'   => 'required|exists:kantor,id',
            'nama_divisi' => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'status'      => 'required|boolean',
        ]);

        $divisi->updateDivisi($request->all());

        return redirect()
            ->route('divisi.index')
            ->with('success', 'Divisi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $divisi = Divisi::findOrFail($id);
        $divisi->delete();

        return redirect()
            ->route('divisi.index')
            ->with('success', 'Divisi berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        try {
            $divisi = Divisi::findOrFail($id);
            $divisi->toggleStatus();

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
