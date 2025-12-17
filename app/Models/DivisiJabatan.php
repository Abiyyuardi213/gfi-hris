<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DivisiJabatan extends Model
{
    protected $table = 'divisi_jabatan';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'divisi_id',
        'jabatan_id',
        'status',
    ];

    protected static function booted()
    {
        static::creating(function ($divisiJabatan) {
            if (!$divisiJabatan->id) {
                $divisiJabatan->id = (string) Str::uuid();
            }
        });
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'divisi_id');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }

    public static function createDivisiJabatan(array $data)
    {
        return self::create([
            'divisi_id'  => $data['divisi_id'],
            'jabatan_id' => $data['jabatan_id'],
            'status'     => $data['status'] ?? true,
        ]);
    }

    public function updateDivisiJabatan(array $data)
    {
        $this->update([
            'divisi_id'  => $data['divisi_id'],
            'jabatan_id' => $data['jabatan_id'],
            'status'     => $data['status'] ?? $this->status,
        ]);
    }

    public function toggleStatus()
    {
        $this->status = !$this->status;
        $this->save();
    }
}
