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
        'kode_status',
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
        });
    }

    // public function pegawais()
    // {
    //     return $this->hasMany(Pegawai::class, 'status_pegawai_id');
    // }

    public static function createStatus(array $data)
    {
        return self::create([
            'kode_status' => strtoupper($data['kode_status']),
            'nama_status' => $data['nama_status'],
            'keterangan'  => $data['keterangan'] ?? null,
            'is_aktif'    => $data['is_aktif'] ?? true,
        ]);
    }

    public function updateStatus(array $data)
    {
        $this->update([
            'kode_status' => strtoupper($data['kode_status']),
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
}
