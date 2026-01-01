<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Lamaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lamarans';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'lowongan_id',
        'kandidat_id',
        'status',
        'catatan_admin'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class, 'lowongan_id');
    }

    public function kandidat()
    {
        return $this->belongsTo(Kandidat::class, 'kandidat_id');
    }

    public function wawancaras()
    {
        return $this->hasMany(Wawancara::class, 'lamaran_id');
    }
}
