<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assets = Asset::with('pegawai')->latest()->get();
        return view('assets.index', compact('assets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::orderBy('nama_lengkap')->get();
        // Generate Auto Code: INV/YYYY/00X
        $year = date('Y');
        $lastAsset = Asset::where('kode_aset', 'like', 'INV/' . $year . '/%')
            ->orderBy('kode_aset', 'desc')
            ->first();

        if ($lastAsset) {
            $lastNumber = (int) substr($lastAsset->kode_aset, -3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        $kode_aset = 'INV/' . $year . '/' . sprintf('%03d', $newNumber);

        return view('assets.create', compact('pegawais', 'kode_aset'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_aset' => 'required|unique:assets',
            'nama_aset' => 'required',
            'kategori' => 'required',
            'kondisi' => 'required',
            'status' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->all();

            if ($request->hasFile('foto')) {
                $path = $request->file('foto')->store('aset-images', 'public');
                $data['foto'] = $path;
            }

            Asset::create($data);

            DB::commit();
            return redirect()->route('assets.index')->with('success', 'Aset berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal menambahkan aset: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $asset = Asset::with('pegawai')->findOrFail($id);
        return view('assets.show', compact('asset'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $asset = Asset::findOrFail($id);
        $pegawais = Pegawai::orderBy('nama_lengkap')->get();
        return view('assets.edit', compact('asset', 'pegawais'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_aset' => 'required',
            'kategori' => 'required',
            'kondisi' => 'required',
            'status' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $asset = Asset::findOrFail($id);
            $data = $request->all();

            if ($request->hasFile('foto')) {
                if ($asset->foto) Storage::disk('public')->delete($asset->foto);
                $path = $request->file('foto')->store('aset-images', 'public');
                $data['foto'] = $path;
            }

            $asset->update($data);

            DB::commit();
            return redirect()->route('assets.index')->with('success', 'Aset berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal memperbarui aset: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $asset = Asset::findOrFail($id);
            if ($asset->foto) Storage::disk('public')->delete($asset->foto);
            $asset->delete();
            return redirect()->route('assets.index')->with('success', 'Aset berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus aset: ' . $e->getMessage());
        }
    }
}
