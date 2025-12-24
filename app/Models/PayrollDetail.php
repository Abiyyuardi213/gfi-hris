<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PayrollDetail extends Model
{
    use HasFactory;

    protected $table = 'payroll_details';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'payroll_id',
        'nama_komponen',
        'tipe',
        'jumlah',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }
}
