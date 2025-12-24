<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class HariLibur extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'hari_libur';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'nama_libur',
        'tanggal',
        'is_cuti_bersama',
        'kantor_id',
        'deskripsi',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'is_cuti_bersama' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public static function createLibur($data)
    {
        return self::create([
            'nama_libur'       => $data['nama_libur'],
            'tanggal'          => $data['tanggal'],
            'is_cuti_bersama'  => $data['is_cuti_bersama'] ?? false,
            'kantor_id'        => $data['kantor_id'] ?? null,
            'deskripsi'        => $data['deskripsi'] ?? null,
        ]);
    }

    public function updateLibur($data)
    {
        return $this->update([
            'nama_libur'       => $data['nama_libur'],
            'tanggal'          => $data['tanggal'],
            'is_cuti_bersama'  => $data['is_cuti_bersama'] ?? $this->is_cuti_bersama,
            'kantor_id'        => array_key_exists('kantor_id', $data) ? $data['kantor_id'] : $this->kantor_id,
            'deskripsi'        => $data['deskripsi'] ?? $this->deskripsi,
        ]);
    }

    public function kantor()
    {
        return $this->belongsTo(Kantor::class, 'kantor_id');
    }
}
