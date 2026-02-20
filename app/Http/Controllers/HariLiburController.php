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
            // Using a more reliable and up-to-date API for Indonesian Holidays
            // Today's date from system is 2026.
            $year = date('Y');
            $yearsToSync = [$year, $year + 1];
            $count = 0;

            foreach ($yearsToSync as $y) {
                // Try several API variants if one fails
                $endpoints = [
                    "https://api-hari-libur.vercel.app/api?year={$y}",
                    "https://libur.deno.dev/api?year={$y}"
                ];

                foreach ($endpoints as $url) {
                    $response = \Illuminate\Support\Facades\Http::timeout(10)->get($url);

                    if ($response->successful()) {
                        $holidays = $response->json();

                        // Handle structure from api-hari-libur.vercel.app which might be [ { "holiday_date": "...", "holiday_name": "..." } ]
                        // or { "data": [...] }
                        $data = isset($holidays['data']) ? $holidays['data'] : $holidays;

                        if (is_array($data)) {
                            foreach ($data as $h) {
                                // Extract date and name with various possible keys
                                $tanggalStr = $h['holiday_date'] ?? $h['tanggal'] ?? $h['date'] ?? null;
                                $nama = $h['holiday_name'] ?? $h['keterangan'] ?? $h['name'] ?? null;
                                $isCuti = $h['is_cuti'] ?? (isset($nama) && strpos(strtolower($nama), 'cuti bersama') !== false);

                                if (!$tanggalStr || !$nama) continue;

                                // Normalize date format to Y-m-d
                                try {
                                    $tanggal = \Carbon\Carbon::parse($tanggalStr)->format('Y-m-d');
                                } catch (\Exception $e) {
                                    continue;
                                }

                                // Check if already exists by date and name to avoid duplicates
                                $exists = HariLibur::where('tanggal', $tanggal)
                                    ->where('nama_libur', $nama)
                                    ->exists();

                                if (!$exists) {
                                    HariLibur::create([
                                        'nama_libur'      => $nama,
                                        'tanggal'         => $tanggal,
                                        'is_cuti_bersama' => $isCuti,
                                        'kantor_id'       => null,
                                        'deskripsi'       => 'Sinkronisasi Otomatis API (Standard 2026)'
                                    ]);
                                    $count++;
                                }
                            }
                            // If we successfully got data from one endpoint, no need to try the next one for this year
                            break;
                        }
                    }
                }
            }

            $msg = $count > 0
                ? "Berhasil menyinkronkan {$count} hari libur baru untuk tahun {$year} & " . ($year + 1) . "."
                : "Sinkronisasi selesai. Tidak ada hari libur baru yang ditambahkan (data sudah mutakhir).";

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $msg
                ]);
            }

            return redirect()
                ->route('hari-libur.index')
                ->with('success', $msg);
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyinkronkan data: ' . $e->getMessage()
                ], 500);
            }

            return redirect()
                ->route('hari-libur.index')
                ->with('error', 'Gagal menyinkronkan data: ' . $e->getMessage());
        }
    }
}
