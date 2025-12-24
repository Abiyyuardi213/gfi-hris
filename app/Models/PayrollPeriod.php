<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PayrollPeriod extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'payroll_periods';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'nama_periode',
        'bulan',
        'tahun',
        'start_date',
        'end_date',
        'is_closed',
        'tanggal_gajian',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'tanggal_gajian' => 'date',
        'is_closed' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class, 'payroll_period_id');
    }
}
