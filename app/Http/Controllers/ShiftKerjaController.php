<?php

namespace App\Http\Controllers;

use App\Models\ShiftKerja;
use Illuminate\Http\Request;

class ShiftKerjaController extends Controller
{
    public function index()
    {
        $shifts = ShiftKerja::orderBy('created_at', 'asc')->get();
        return view('shift-kerja.index', compact('shifts'));
    }

    public function create()
    {
        return view('shift-kerja.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_shift' => 'required|string|max:255',
            'jam_masuk'  => 'required',
            'jam_keluar' => 'required',
            'status'     => 'required|boolean',
        ]);

        $shift = ShiftKerja::createShift($request->all());

        return redirect()
            ->route('shift-kerja.index')
            ->with('success', 'Shift Kerja berhasil ditambahkan.')
            ->with('target_id', $shift->id);
    }

    public function edit($id)
    {
        $shift = ShiftKerja::findOrFail($id);
        return view('shift-kerja.edit', compact('shift'));
    }

    public function update(Request $request, $id)
    {
        $shift = ShiftKerja::findOrFail($id);

        $request->validate([
            'nama_shift' => 'required|string|max:255',
            'jam_masuk'  => 'required',
            'jam_keluar' => 'required',
            'status'     => 'required|boolean',
        ]);

        $shift->updateShift($request->all());

        return redirect()
            ->route('shift-kerja.index')
            ->with('success', 'Shift Kerja berhasil diperbarui.')
            ->with('target_id', $shift->id);
    }

    public function destroy($id)
    {
        $shift = ShiftKerja::findOrFail($id);
        $shift->delete();

        return redirect()
            ->route('shift-kerja.index')
            ->with('success', 'Shift Kerja berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        try {
            $shift = ShiftKerja::findOrFail($id);
            $shift->toggleStatus();

            return response()->json([
                'success' => true,
                'message' => 'Status shift berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status shift.'
            ], 500);
        }
    }
}
