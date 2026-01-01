<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecruitmentProcessController extends Controller
{
    public function show($id)
    {
        $lamaran = \App\Models\Lamaran::with(['kandidat.user', 'lowongan', 'wawancaras'])->findOrFail($id);
        return view('recruitment.admin.lamaran.show', compact('lamaran'));
    }

    public function updateStatus(Request $request, $id)
    {
        $lamaran = \App\Models\Lamaran::findOrFail($id);

        // Validate Status
        $request->validate([
            'status' => 'required|in:Pending,Review,Interview,Diterima,Ditolak',
            'catatan_admin' => 'nullable|string'
        ]);

        $lamaran->status = $request->status;
        if ($request->catatan_admin) {
            $lamaran->catatan_admin = $request->catatan_admin;
        }
        $lamaran->save();

        // Optional: Send Notification to Candidate

        return back()->with('success', 'Status lamaran berhasil diperbarui menjadi ' . $request->status);
    }

    public function scheduleInterview(Request $request, $id)
    {
        $lamaran = \App\Models\Lamaran::findOrFail($id);

        $request->validate([
            'tanggal_waktu' => 'required|date',
            'tipe' => 'required|in:Online,Offline',
            'lokasi_link' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        // Auto update status to Interview
        $lamaran->status = 'Interview';
        $lamaran->save();

        \App\Models\Wawancara::create([
            'lamaran_id' => $lamaran->id,
            'tanggal_waktu' => $request->tanggal_waktu,
            'tipe' => $request->tipe,
            'lokasi_link' => $request->lokasi_link,
            'catatan' => $request->catatan,
            'status' => 'Terjadwal'
        ]);

        return back()->with('success', 'Wawancara berhasil dijadwalkan.');
    }
}
