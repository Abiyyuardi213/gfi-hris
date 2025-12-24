<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Payroll extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'payrolls';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'payroll_period_id',
        'pegawai_id',
        'gaji_pokok',
        'total_tunjangan',
        'total_potongan',
        'gaji_bersih',
        'catatan',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function payrollPeriod()
    {
        return $this->belongsTo(PayrollPeriod::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function details()
    {
        return $this->hasMany(PayrollDetail::class);
    }
}
