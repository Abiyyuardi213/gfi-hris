<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Pegawai extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pegawais';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'status_pegawai_id',
        'divisi_id',
        'jabatan_id',
        'kantor_id',
        'nip',
        'nik',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'status_pernikahan',
        'alamat_ktp',
        'alamat_domisili',
        'no_hp',
        'email_pribadi',
        'tanggal_masuk',
        'tanggal_keluar',
        'foto',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_masuk' => 'date',
        'tanggal_keluar' => 'date',
    ];

    protected static function booted()
    {
        static::creating(function ($pegawai) {
            if (!$pegawai->id) {
                $pegawai->id = (string) Str::uuid();
            }

            if (!$pegawai->nip) {
                $pegawai->nip = self::generateNip($pegawai->tanggal_masuk);
            }
        });
    }

    /**
     * Generate NIP
     * Format: YYYYMM (Tgl Masuk) + Urutan (3 Digit) + Random (3 Digit Angka)
     */
    public static function generateNip($tanggalMasuk)
    {
        // Parse Tanggal Masuk
        $date = \Carbon\Carbon::parse($tanggalMasuk);
        $year = $date->format('Y');
        $month = $date->format('m');
        $prefix = $year . $month;

        // Hitung urutan pegawai yang masuk pada bulan & tahun tersebut
        // Urutan berdasarkan created_at atau tanggal_masuk? Logic "urutan pegawai ke berapa"
        // Kita hitung berdasarkan data di database yang memiliki prefix sama.
        // NOTE: Ini bisa race condition jika concurrent tinggi, tapi ok untuk MVP.
        $count = self::whereYear('tanggal_masuk', $year)
            ->whereMonth('tanggal_masuk', $month)
            ->count();

        $sequence = str_pad($count + 1, 3, '0', STR_PAD_LEFT);

        // Random 3 digit angka
        $random = str_pad(mt_rand(0, 999), 3, '0', STR_PAD_LEFT);

        return $prefix . $sequence . $random;
    }

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statusPegawai()
    {
        return $this->belongsTo(StatusPegawai::class);
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function kantor()
    {
        return $this->belongsTo(Kantor::class);
    }
}
