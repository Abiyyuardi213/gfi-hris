<?php

namespace App\Http\Controllers;

use App\Models\StatusPegawai;
use Illuminate\Http\Request;

class StatusPegawaiController extends Controller
{
    public function index()
    {
        $statuses = StatusPegawai::orderBy('created_at', 'asc')->get();

        return view('status_pegawai.index', compact('statuses'));
    }

    public function create()
    {
        return view('status_pegawai.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_status' => 'required|string|max:100',
            'keterangan'  => 'nullable|string',
            'is_aktif'    => 'required|boolean',
        ]);

        StatusPegawai::createStatus($request->all());

        return redirect()
            ->route('status-pegawai.index')
            ->with('success', 'Status pegawai berhasil ditambahkan.');
    }

    public function show($id)
    {
        $status = StatusPegawai::findOrFail($id);

        return view('status_pegawai.show', compact('status'));
    }

    public function edit($id)
    {
        $status = StatusPegawai::findOrFail($id);

        return view('status_pegawai.edit', compact('status'));
    }

    public function update(Request $request, $id)
    {
        $status = StatusPegawai::findOrFail($id);

        $request->validate([
            'nama_status' => 'required|string|max:100',
            'keterangan'  => 'nullable|string',
            'is_aktif'    => 'required|boolean',
        ]);

        $status->updateStatus($request->all());

        return redirect()
            ->route('status-pegawai.index')
            ->with('success', 'Status pegawai berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $status = StatusPegawai::findOrFail($id);

        $status->delete();

        return redirect()
            ->route('status-pegawai.index')
            ->with('success', 'Status pegawai berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        try {
            $status = StatusPegawai::findOrFail($id);
            $status->toggleStatus();

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status.'
            ], 500);
        }
    }
}
