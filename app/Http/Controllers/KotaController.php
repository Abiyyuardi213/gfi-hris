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

    public function sync()
    {
        set_time_limit(300); // 5 minutes

        try {
            $provinces = \Illuminate\Support\Facades\Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')->json();

            $count = 0;
            if ($provinces) {
                foreach ($provinces as $province) {
                    $regencies = \Illuminate\Support\Facades\Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/regencies/{$province['id']}.json")->json();

                    if ($regencies) {
                        foreach ($regencies as $regency) {
                            // Format: KAB. ACEH BARAT -> Tipe: Kabupaten, Nama: Aceh Barat
                            // Format: KOTA BANDA ACEH -> Tipe: Kota, Nama: Banda Aceh

                            $fullName = $regency['name'];
                            $tipe = 'Kabupaten'; // Default

                            if (str_starts_with($fullName, 'KOTA ')) {
                                $tipe = 'Kota';
                            } elseif (str_starts_with($fullName, 'KAB. ')) {
                                $tipe = 'Kabupaten';
                            }

                            // Title case for name (e.g. KAB. ACEH BARAT -> Kab. Aceh Barat)
                            $namaKota = ucwords(strtolower($fullName));

                            Kota::updateOrCreate(
                                ['kota' => $namaKota],
                                ['tipe' => $tipe]
                            );
                            $count++;
                        }
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Berhasil sinkronasi {$count} data kota/kabupaten."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal sinkronasi: ' . $e->getMessage()
            ], 500);
        }
    }
}
