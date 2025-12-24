<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Jabatan extends Model
{
    protected $table = 'jabatan';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'divisi_id',
        'kode_jabatan',
        'nama_jabatan',
        'gaji_per_hari',
        'deskripsi',
        'status',
    ];

    protected static function booted()
    {
        static::creating(function ($jabatan) {

            if (!$jabatan->id) {
                $jabatan->id = (string) Str::uuid();
            }

            if (!$jabatan->kode_jabatan) {
                $jabatan->kode_jabatan = self::generateKodeJabatan($jabatan->nama_jabatan);
            }
        });
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'divisi_id');
    }

    protected static function generateKodeJabatan(string $namaJabatan): string
    {
        $kodeNama = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $namaJabatan), 0, 3));

        if (strlen($kodeNama) < 3) {
            $kodeNama = str_pad($kodeNama, 3, 'X');
        }

        $lastKode = self::where('kode_jabatan', 'LIKE', 'JBT%')
            ->orderBy('created_at', 'desc')
            ->value('kode_jabatan');

        $lastNumber = $lastKode
            ? intval(substr($lastKode, 3, 3))
            : 0;

        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        return "JBT{$newNumber}{$kodeNama}";
    }

    public static function createJabatan(array $data)
    {
        return self::create([
            'divisi_id'    => $data['divisi_id'],
            'nama_jabatan' => $data['nama_jabatan'],
            'gaji_per_hari' => $data['gaji_per_hari'],
            'deskripsi'    => $data['deskripsi'] ?? null,
            'status'       => $data['status'] ?? true,
        ]);
    }

    public function updateJabatan(array $data)
    {
        $this->update([
            'divisi_id'    => $data['divisi_id'],
            'nama_jabatan' => $data['nama_jabatan'],
            'gaji_per_hari' => $data['gaji_per_hari'],
            'deskripsi'    => $data['deskripsi'] ?? $this->deskripsi,
            'status'       => $data['status'] ?? $this->status,
        ]);
    }

    public function divisiJabatan()
    {
        return $this->hasMany(DivisiJabatan::class, 'jabatan_id');
    }

    public function toggleStatus()
    {
        $this->status = !$this->status;
        $this->save();
    }
}
