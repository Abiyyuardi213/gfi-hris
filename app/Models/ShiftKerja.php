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
            if (!$model->kode_shift) {
                $model->kode_shift = self::generateKodeShift();
            }
        });
    }

    public static function createShift($data)
    {
        return self::create([
            'kode_shift' => self::generateKodeShift(),
            'nama_shift' => $data['nama_shift'],
            'jam_masuk'  => $data['jam_masuk'],
            'jam_keluar' => $data['jam_keluar'],
            'status'     => $data['status'] ?? true,
        ]);
    }

    protected static function generateKodeShift(): string
    {
        $lastKode = self::withTrashed()
            ->where('kode_shift', 'LIKE', 'SHF%')
            ->orderBy('created_at', 'desc')
            ->value('kode_shift');

        $lastNumber = $lastKode
            ? intval(substr($lastKode, 3, 3))
            : 0;

        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        return "SHF{$newNumber}";
    }

    public function updateShift($data)
    {
        return $this->update([
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
