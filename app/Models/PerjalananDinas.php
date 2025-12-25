<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PerjalananDinas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'perjalanan_dinas';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'pegawai_id',
        'no_surat_tugas',
        'tujuan',
        'keperluan',
        'tanggal_mulai',
        'tanggal_selesai',
        'jenis_transportasi',
        'estimasi_biaya',
        'realisasi_biaya',
        'status',
        'catatan_persetujuan',
        'disetujui_oleh',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function peserta()
    {
        return $this->belongsToMany(Pegawai::class, 'perjalanan_dinas_peserta', 'perjalanan_dinas_id', 'pegawai_id');
    }

    // Keep this for backward compatibility or as the "Primary Contact / Creator" if needed, 
    // but in new logic we use peserta. 
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function approver()
    {
        return $this->belongsTo(Pegawai::class, 'disetujui_oleh');
    }

    public function biayaDinas()
    {
        return $this->hasMany(BiayaDinas::class);
    }
}
