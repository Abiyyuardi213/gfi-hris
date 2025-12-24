<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Lembur extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lemburs';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'pegawai_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'keterangan',
        'status',
        'catatan_approval',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_mulai' => 'datetime', // or 'string' if we want just H:i, but datetime is better for Carbon
        'jam_selesai' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
