<?php

namespace App\Http\Controllers;

use App\Models\Kantor;
use App\Models\Kota;
use Illuminate\Http\Request;

class KantorController extends Controller
{
    public function index()
    {
        $kantors = Kantor::with('kota')->orderBy('created_at', 'asc')->get();
        return view('kantor.index', compact('kantors'));
    }

    public function create()
    {
        $kotas = Kota::all();
        return view('kantor.create', compact('kotas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kantor' => 'required|string|max:255',
            'tipe_kantor' => 'required|in:Pusat,Cabang',
            'no_telp'     => 'nullable|string',
            'email'       => 'nullable|email',
            'kota_id'     => 'nullable|exists:kota,id',
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
        $kantor = Kantor::with('kota')->findOrFail($id);
        return view('kantor.show', compact('kantor'));
    }

    public function edit($id)
    {
        $kantor = Kantor::findOrFail($id);
        $kotas = Kota::all();
        return view('kantor.edit', compact('kantor', 'kotas'));
    }

    public function update(Request $request, $id)
    {
        $kantor = Kantor::findOrFail($id);

        $request->validate([
            'nama_kantor' => 'required|string|max:255',
            'tipe_kantor' => 'required|in:Pusat,Cabang',
            'no_telp'     => 'nullable|string',
            'email'       => 'nullable|email',
            'kota_id'     => 'nullable|exists:kota,id',
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
        $kantor->delete(); // Changed from deleteKantor() as standard delete is available

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
