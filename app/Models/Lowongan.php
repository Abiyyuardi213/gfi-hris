<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Lowongan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lowongans';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'judul',
        'deskripsi',
        'kualifikasi',
        'lokasi_penempatan',
        'tipe_pekerjaan',
        'gaji_min',
        'gaji_max',
        'tanggal_mulai',
        'tanggal_akhir',
        'is_active'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_akhir' => 'date',
        'gaji_min' => 'decimal:2',
        'gaji_max' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function lamarans()
    {
        return $this->hasMany(Lamaran::class, 'lowongan_id');
    }
}
