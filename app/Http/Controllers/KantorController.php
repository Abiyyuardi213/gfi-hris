<?php

namespace App\Http\Controllers;

use App\Models\Kantor;
use Illuminate\Http\Request;

class KantorController extends Controller
{
    public function index()
    {
        $kantors = Kantor::orderBy('created_at', 'asc')->get();
        return view('kantor.index', compact('kantors'));
    }

    public function create()
    {
        return view('kantor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kantor' => 'required|string|max:255',
            'alamat'      => 'nullable|string',
            'status'      => 'required|boolean',
        ]);

        Kantor::createKantor($request->all());

        return redirect()
            ->route('kantor.index')
            ->with('success', 'Kantor berhasil ditambahkan.');
    }

    public function show($id)
    {
        $kantor = Kantor::findOrFail($id);
        return view('kantor.show', compact('kantor'));
    }

    public function edit($id)
    {
        $kantor = Kantor::findOrFail($id);
        return view('kantor.edit', compact('kantor'));
    }

    public function update(Request $request, $id)
    {
        $kantor = Kantor::findOrFail($id);

        $request->validate([
            'nama_kantor' => 'required|string|max:255',
            'alamat'      => 'nullable|string',
            'status'      => 'required|boolean',
        ]);

        $kantor->updateKantor($request->all());

        return redirect()
            ->route('kantor.index')
            ->with('success', 'Kantor berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kantor = Kantor::findOrFail($id);
        $kantor->deleteKantor();

        return redirect()
            ->route('kantor.index')
            ->with('success', 'Kantor berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        try {
            $kantor = Kantor::findOrFail($id);
            $kantor->toggleStatus();

            return response()->json([
                'success' => true,
                'message' => 'Status kantor berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status kantor.'
            ], 500);
        }
    }
}
