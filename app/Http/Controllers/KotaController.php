<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use Illuminate\Http\Request;

class KotaController extends Controller
{
    public function index()
    {
        $kotas = Kota::orderBy('created_at')->get();
        return view('kota.index', compact('kotas'));
    }

    public function create()
    {
        return view('kota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kota' => 'required|string|max:255|unique:kota,kota',
            'tipe' => 'nullable|in:Kota,Kabupaten'
        ]);

        Kota::createKota($request->all());

        return redirect()->route('kota.index')->with('success', 'Kota berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kota = Kota::findOrFail($id);
        return view('kota.edit', compact('kota'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kota' => 'required|string|max:255|unique:kota,kota,' . $id . ',id',
            'tipe' => 'nullable|in:Kota,Kabupaten'
        ]);

        $kota = Kota::findOrFail($id);
        $kota->updateKota($request->all());

        return redirect()->route('kota.index')->with('success', 'Kota berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kota = Kota::findOrFail($id);
        $kota->deleteKota();

        return redirect()->route('kota.index')->with('success', 'Kota berhasil dihapus.');
    }
}
