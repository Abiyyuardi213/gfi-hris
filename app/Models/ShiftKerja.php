<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ShiftKerja extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'shift_kerja';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'kode_shift',
        'nama_shift',
        'jam_masuk',
        'jam_keluar',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public static function createShift($data)
    {
        return self::create([
            'kode_shift' => $data['kode_shift'],
            'nama_shift' => $data['nama_shift'],
            'jam_masuk'  => $data['jam_masuk'],
            'jam_keluar' => $data['jam_keluar'],
            'status'     => $data['status'] ?? true,
        ]);
    }

    public function updateShift($data)
    {
        return $this->update([
            'kode_shift' => $data['kode_shift'],
            'nama_shift' => $data['nama_shift'],
            'jam_masuk'  => $data['jam_masuk'],
            'jam_keluar' => $data['jam_keluar'],
            'status'     => $data['status'] ?? $this->status,
        ]);
    }

    public function toggleStatus()
    {
        $this->status = !$this->status;
        $this->save();
    }
}
