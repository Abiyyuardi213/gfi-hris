<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\PayrollDetail;
use App\Models\PayrollPeriod;
use App\Models\Pegawai;
use App\Models\Presensi;
use App\Models\Lembur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PayrollController extends Controller
{
    // === PERIODS ===
    public function index()
    {
        // Check role? Assuming Admin.
        $periods = PayrollPeriod::latest()->get();
        return view('payroll.index', compact('periods'));
    }

    public function createPeriod()
    {
        return view('payroll.create-period');
    }

    public function storePeriod(Request $request)
    {
        $request->validate([
            'nama_periode' => 'required',
            'bulan' => 'required',
            'tahun' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        PayrollPeriod::create($request->all());
        return redirect()->route('payroll.index')->with('success', 'Periode gaji berhasil dibuat.');
    }

    public function showPeriod($id)
    {
        $period = PayrollPeriod::with(['payrolls.pegawai.jabatan'])->findOrFail($id);
        return view('payroll.show-period', compact('period'));
    }

    public function generate(Request $request, $id)
    {
        $period = PayrollPeriod::findOrFail($id);

        if ($period->is_closed) {
            return redirect()->back()->with('error', 'Periode ini sudah ditutup.');
        }

        $pegawais = Pegawai::where('status_pegawai_id', '!=', null)->with('jabatan')->get(); // Assume active check

        DB::beginTransaction();
        try {
            Payroll::where('payroll_period_id', $id)->delete();

            foreach ($pegawais as $pegawai) {
                $gajiPerHari = $pegawai->jabatan ? $pegawai->jabatan->gaji_per_hari : 0;

                $presensis = Presensi::where('pegawai_id', $pegawai->id)
                    ->whereBetween('tanggal', [$period->start_date, $period->end_date])
                    ->get();

                $totalHadir = $presensis->count();
                $totalTerlambatMenit = $presensis->sum('terlambat');

                $gajiPokok = $gajiPerHari * $totalHadir;

                $lemburs = Lembur::where('pegawai_id', $pegawai->id)
                    ->where('status', 'Disetujui')
                    ->whereBetween('tanggal', [$period->start_date, $period->end_date])
                    ->get();

                $totalJamLembur = 0;
                foreach ($lemburs as $l) {
                    if ($l->jam_mulai && $l->jam_selesai) {
                        $durasi = $l->jam_selesai->diffInHours($l->jam_mulai);
                        $totalJamLembur += $durasi;
                    }
                }

                $hourlyRate = $gajiPerHari > 0 ? ($gajiPerHari / 8) : 0;
                $upahLembur = $totalJamLembur * $hourlyRate * 1.5;

                $allowances = [];
                $deductions = [];

                if ($upahLembur > 0) {
                    $allowances[] = [
                        'name' => 'Lembur (' . $totalJamLembur . ' Jam)',
                        'amount' => $upahLembur
                    ];
                }

                $bpjs = $gajiPokok * 0.02;
                if ($bpjs > 0) {
                    $deductions[] = [
                        'name' => 'BPJS Kesehatan (2%)',
                        'amount' => $bpjs
                    ];
                }

                // Terlambat (Penalty)
                // Example: 1000 per minute
                $dendaTerlambat = $totalTerlambatMenit * 500; // Rp 500 per menit
                if ($dendaTerlambat > 0) {
                    $deductions[] = [
                        'name' => 'Potongan Terlambat (' . $totalTerlambatMenit . ' mnt)',
                        'amount' => $dendaTerlambat
                    ];
                }

                // Sum
                $totalTunjangan = collect($allowances)->sum('amount');
                $totalPotongan = collect($deductions)->sum('amount');
                $gajiBersih = $gajiPokok + $totalTunjangan - $totalPotongan;

                // Store
                $payroll = Payroll::create([
                    'payroll_period_id' => $period->id,
                    'pegawai_id' => $pegawai->id,
                    'gaji_pokok' => $gajiPokok,
                    'total_tunjangan' => $totalTunjangan,
                    'total_potongan' => $totalPotongan,
                    'gaji_bersih' => max(0, $gajiBersih), // No negative salary
                ]);

                // Store Details
                // Gaji Pokok as Detail too? Usually yes for slip.
                PayrollDetail::create([
                    'payroll_id' => $payroll->id,
                    'nama_komponen' => 'Gaji Pokok (' . $totalHadir . ' Hari)',
                    'tipe' => 'pendapatan',
                    'jumlah' => $gajiPokok
                ]);

                foreach ($allowances as $a) {
                    PayrollDetail::create([
                        'payroll_id' => $payroll->id,
                        'nama_komponen' => $a['name'],
                        'tipe' => 'pendapatan',
                        'jumlah' => $a['amount']
                    ]);
                }

                foreach ($deductions as $d) {
                    PayrollDetail::create([
                        'payroll_id' => $payroll->id,
                        'nama_komponen' => $d['name'],
                        'tipe' => 'potongan',
                        'jumlah' => $d['amount']
                    ]);
                }

                // Notify User
                if ($pegawai->user) {
                    $pegawai->user->notify(new \App\Notifications\PayrollNotification($period->nama_periode));
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Perhitungan gaji berhasil digenerate.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal generate gaji: ' . $e->getMessage());
        }
    }

    // === EXPORT / SLIP ===
    public function show($id)
    {
        $payroll = Payroll::with(['pegawai.jabatan', 'payrollPeriod', 'details'])->findOrFail($id);

        // Authorization check if Pegawai?
        if (Auth::user()->role->role_name == 'Pegawai') {
            if ($payroll->pegawai->user_id != Auth::id()) {
                abort(403);
            }
        }

        return view('payroll.show', compact('payroll'));
    }

    public function userIndex()
    {
        $user = Auth::user();
        $pegawai = Pegawai::where('user_id', $user->id)->first();
        if (!$pegawai) abort(404);

        $payrolls = Payroll::where('pegawai_id', $pegawai->id)
            ->with('payrollPeriod')
            ->latest()
            ->get();

        return view('payroll.user-index', compact('payrolls'));
    }
}
