<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wawancara extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory, \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = 'wawancaras';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'lamaran_id',
        'tanggal_waktu',
        'tipe',
        'lokasi_link',
        'catatan',
        'status'
    ];

    protected $casts = [
        'tanggal_waktu' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }

    public function lamaran()
    {
        return $this->belongsTo(Lamaran::class, 'lamaran_id');
    }
}
