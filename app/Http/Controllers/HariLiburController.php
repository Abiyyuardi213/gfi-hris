<?php

namespace App\Http\Controllers;

use App\Models\HariLibur;
use App\Models\Kantor;
use Illuminate\Http\Request;

class HariLiburController extends Controller
{
    public function index()
    {
        $hariLiburs = HariLibur::with('kantor')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('hari-libur.index', compact('hariLiburs'));
    }

    public function create()
    {
        $kantors = Kantor::where('status', true)->orderBy('nama_kantor')->get();
        return view('hari-libur.create', compact('kantors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_libur'       => 'required|string|max:255',
            'tanggal'          => 'required|date',
            'is_cuti_bersama'  => 'required|boolean',
            'kantor_id'        => 'nullable|exists:kantor,id',
            'deskripsi'        => 'nullable|string',
        ]);

        HariLibur::createLibur($request->all());

        return redirect()
            ->route('hari-libur.index')
            ->with('success', 'Hari Libur berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $hariLibur = HariLibur::findOrFail($id);
        $kantors = Kantor::where('status', true)->orderBy('nama_kantor')->get();
        return view('hari-libur.edit', compact('hariLibur', 'kantors'));
    }

    public function update(Request $request, $id)
    {
        $hariLibur = HariLibur::findOrFail($id);

        $request->validate([
            'nama_libur'       => 'required|string|max:255',
            'tanggal'          => 'required|date',
            'is_cuti_bersama'  => 'required|boolean',
            'kantor_id'        => 'nullable|exists:kantor,id',
            'deskripsi'        => 'nullable|string',
        ]);

        $hariLibur->updateLibur($request->all());

        return redirect()
            ->route('hari-libur.index')
            ->with('success', 'Hari Libur berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $hariLibur = HariLibur::findOrFail($id);
        $hariLibur->delete();

        return redirect()
            ->route('hari-libur.index')
            ->with('success', 'Hari Libur berhasil dihapus.');
    }
}
