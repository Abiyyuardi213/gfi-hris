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

    public function syncFromApi()
    {
        try {
            $year = date('Y');
            $yearsToSync = [$year, $year + 1];
            $count = 0;

            foreach ($yearsToSync as $y) {
                $endpoints = [
                    "https://libur.deno.dev/api?year={$y}",
                    "https://api-hari-libur.vercel.app/api?year={$y}",
                    "https://dayoffapi.vercel.app/api/v1/holidays?year={$y}"
                ];

                foreach ($endpoints as $url) {
                    try {
                        $response = \Illuminate\Support\Facades\Http::timeout(10)->get($url);
                        if ($response->successful()) {
                            $holidays = $response->json();
                            $data = $holidays;
                            if (isset($holidays['data'])) $data = $holidays['data'];
                            elseif (isset($holidays['holidays'])) $data = $holidays['holidays'];

                            if (is_array($data) && count($data) > 0) {
                                foreach ($data as $h) {
                                    $tanggalStr = $h['holiday_date'] ?? $h['tanggal'] ?? $h['date'] ?? null;
                                    $nama = $h['holiday_name'] ?? $h['keterangan'] ?? $h['name'] ?? null;
                                    if (!$tanggalStr || !$nama) continue;

                                    try {
                                        $tanggal = \Carbon\Carbon::parse($tanggalStr)->format('Y-m-d');
                                    } catch (\Exception $e) {
                                        continue;
                                    }

                                    $isCuti = isset($h['is_cuti']) ? $h['is_cuti'] : (strpos(strtolower($nama), 'cuti bersama') !== false);

                                    $exists = HariLibur::where('tanggal', $tanggal)
                                        ->where('nama_libur', $nama)
                                        ->exists();

                                    if (!$exists) {
                                        HariLibur::create([
                                            'nama_libur'      => $nama,
                                            'tanggal'         => $tanggal,
                                            'is_cuti_bersama' => (bool)$isCuti,
                                            'kantor_id'       => null,
                                            'deskripsi'       => 'Sinkronisasi Otomatis API'
                                        ]);
                                        $count++;
                                    }
                                }
                                break;
                            }
                        }
                    } catch (\Exception $e) {
                        continue;
                    }
                }
            }

            $totalData = HariLibur::count();
            $msg = $count > 0
                ? "Berhasil menyinkronkan {$count} hari libur baru. Total data: {$totalData}."
                : ($totalData > 0
                    ? "Sinkronisasi selesai. Tidak ada hari libur baru yang ditambahkan. Total data: {$totalData}."
                    : "Gagal menarik data dari API. Pastikan sumber API memiliki data untuk tahun " . implode(' & ', $yearsToSync));

            if (request()->ajax()) {
                return response()->json(['success' => $count > 0 || $totalData > 0, 'message' => $msg]);
            }
            return redirect()->route('hari-libur.index')->with($count > 0 || $totalData > 0 ? 'success' : 'error', $msg);
        } catch (\Exception $e) {
            if (request()->ajax()) return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
            return redirect()->route('hari-libur.index')->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
