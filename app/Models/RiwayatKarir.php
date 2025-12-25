<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class RiwayatKarir extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    protected $casts = [
        'tanggal_efektif' => 'date',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function jabatanAwal()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_awal_id');
    }

    public function jabatanTujuan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_tujuan_id');
    }

    public function divisiAwal()
    {
        return $this->belongsTo(Divisi::class, 'divisi_awal_id');
    }

    public function divisiTujuan()
    {
        return $this->belongsTo(Divisi::class, 'divisi_tujuan_id');
    }

    public function kantorAwal()
    {
        return $this->belongsTo(Kantor::class, 'kantor_awal_id');
    }

    public function kantorTujuan()
    {
        return $this->belongsTo(Kantor::class, 'kantor_tujuan_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}
