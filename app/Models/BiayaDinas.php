<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BiayaDinas extends Model
{
    use HasFactory;

    protected $table = 'biaya_dinas';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'perjalanan_dinas_id',
        'nama_biaya',
        'jumlah',
        'bukti_pendukung',
        'keterangan',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function perjalananDinas()
    {
        return $this->belongsTo(PerjalananDinas::class);
    }
}
