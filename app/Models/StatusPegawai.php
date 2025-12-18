<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StatusPegawai extends Model
{
    protected $table = 'status_pegawai';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'nama_status',
        'keterangan',
        'is_aktif',
    ];

    protected static function booted()
    {
        static::creating(function ($status) {

            if (!$status->id) {
                $status->id = (string) Str::uuid();
            }

            if (!$status->kode_status) {
                $status->kode_status = self::generateKodeStatus();
            }
        });
    }

    protected static function generateKodeStatus(): string
    {
        $lastKode = self::orderBy('created_at', 'desc')
            ->value('kode_status');

        $lastNumber = $lastKode
            ? intval(substr($lastKode, 3))
            : 0;

        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        return "STS{$newNumber}";
    }

    public static function createStatus(array $data)
    {
        return self::create([
            'nama_status' => $data['nama_status'],
            'keterangan'  => $data['keterangan'] ?? null,
            'is_aktif'    => $data['is_aktif'] ?? true,
        ]);
    }

    public function updateStatus(array $data)
    {
        $this->update([
            'nama_status' => $data['nama_status'],
            'keterangan'  => $data['keterangan'] ?? $this->keterangan,
            'is_aktif'    => $data['is_aktif'] ?? $this->is_aktif,
        ]);
    }

    public function toggleStatus()
    {
        $this->is_aktif = !$this->is_aktif;
        $this->save();
    }

    // public function pegawais()
    // {
    //     return $this->hasMany(Pegawai::class, 'status_pegawai_id');
    // }
}
