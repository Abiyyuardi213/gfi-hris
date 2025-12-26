<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Kandidat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kandidats';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'no_hp',
        'alamat',
        'pendidikan_terakhir',
        'file_foto',
        'file_ktp',
        'file_ijazah',
        'file_transkrip',
        'file_cv',
        'file_pendukung',
        'status_lamaran'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
