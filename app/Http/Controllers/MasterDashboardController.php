<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Kota;
use App\Models\Kantor;
use App\Models\Divisi;
use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\ShiftKerja;

class MasterDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'roles' => Role::count(),
            'cities' => Kota::count(),
            'offices' => Kantor::count(),
            'divisions' => Divisi::count(),
            'positions' => Jabatan::count(),
            'employees' => Pegawai::count(),
            'shifts' => ShiftKerja::count(),
        ];

        return view('master.dashboard', compact('stats'));
    }
}
