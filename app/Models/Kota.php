<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kota extends Model
{
    use HasFactory;

    protected $table = 'kota';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'kota',
        'tipe',
    ];

    protected static function booted()
    {
        static::creating(function ($kota) {
            if (!$kota->id) {
                $kota->id = (string) Str::uuid();
            }
        });
    }

    public static function createKota($data)
    {
        return self::create([
            'kota' => $data['kota'],
            'tipe' => $data['tipe'] ?? null,
        ]);
    }

    public function updateKota($data)
    {
        $this->update([
            'kota' => $data['kota'] ?? $this->kota,
            'tipe' => $data['tipe'] ?? $this->tipe,
        ]);
    }

    public function deleteKota()
    {
        return $this->delete();
    }
}
