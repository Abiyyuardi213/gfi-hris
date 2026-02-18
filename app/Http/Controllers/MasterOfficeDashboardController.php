<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kantor;
use App\Models\Divisi;
use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\ShiftKerja;
use App\Models\Asset;
// use App\Models\Mutasi; // Assuming Mutasi model exists or will be added

class MasterOfficeDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'offices' => Kantor::count(),
            'divisions' => Divisi::count(),
            'positions' => Jabatan::count(),
            'employees' => Pegawai::count(),
            'shifts' => ShiftKerja::count(),
            'assets_count' => Asset::count(),
            'assets_value' => Asset::sum('harga_perolehan'),

            // Latest Items for lists
            'new_employees' => Pegawai::with(['jabatan', 'divisi'])->latest('tanggal_masuk')->take(5)->get(),
            'recent_assets' => Asset::latest()->take(5)->get(),
        ];

        return view('master.office_dashboard', compact('stats'));
    }
}
