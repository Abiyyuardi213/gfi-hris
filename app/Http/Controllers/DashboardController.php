<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        // Cek Role Pegawai
        if ($user->role && $user->role->role_name == 'Pegawai') {
            $pegawai = \App\Models\Pegawai::where('user_id', $user->id)->with('shiftKerja')->first();

            if ($pegawai) {
                $today = \Carbon\Carbon::now()->format('Y-m-d');
                $presensi = \App\Models\Presensi::where('pegawai_id', $pegawai->id)
                    ->whereDate('tanggal', $today)
                    ->first();

                // Stats Bulanan
                $currentMonth = date('m');
                $stats = [
                    'hadir' => \App\Models\Presensi::where('pegawai_id', $pegawai->id)->whereMonth('tanggal', $currentMonth)->where('status', 'Hadir')->count(),
                    'terlambat' => \App\Models\Presensi::where('pegawai_id', $pegawai->id)->whereMonth('tanggal', $currentMonth)->where('terlambat', '>', 0)->count(),
                    'izin' => \App\Models\Presensi::where('pegawai_id', $pegawai->id)->whereMonth('tanggal', $currentMonth)->whereIn('status', ['Izin', 'Sakit', 'Cuti'])->count(),
                ];

                // Logs Terakhir
                $logs = \App\Models\Presensi::where('pegawai_id', $pegawai->id)
                    ->orderBy('tanggal', 'desc')
                    ->limit(5)
                    ->get();

                return view('dashboard.pegawai', compact('pegawai', 'presensi', 'stats', 'logs'));
            }
        }

        // Admin Dashboard
        $totalPeran = Role::count();
        $totalPegawai = \App\Models\Pegawai::count();

        // Stats Tambahan
        $currentDate = \Carbon\Carbon::now()->format('Y-m-d');
        $totalHadirToday = \App\Models\Presensi::whereDate('tanggal', $currentDate)->where('status', 'Hadir')->count();

        $totalCutiPending = \App\Models\Cuti::where('status', 'Menunggu')->count();
        $totalLemburPending = \App\Models\Lembur::where('status', 'Menunggu')->count();

        // Pegawai Terbaru
        $latestPegawais = \App\Models\Pegawai::with('jabatan')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalPeran',
            'totalPegawai',
            'totalHadirToday',
            'totalCutiPending',
            'totalLemburPending',
            'latestPegawais'
        ));
    }
}
