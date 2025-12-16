<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Divisi extends Model
{
    protected $table = 'divisi';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'kantor_id',
        'kode_divisi',
        'nama_divisi',
        'deskripsi',
        'status',
    ];

    protected static function booted()
    {
        static::creating(function ($divisi) {
            if (!$divisi->id) {
                $divisi->id = (string) Str::uuid();
            }

            if (!$divisi->kode_divisi) {
                $divisi->kode_divisi = self::generateKodeDivisi($divisi->nama_divisi);
            }
        });
    }

    public function kantor()
    {
        return $this->belongsTo(Kantor::class, 'kantor_id');
    }

    protected static function generateKodeDivisi(string $namaDivisi): string
    {
        $kodeNama = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $namaDivisi), 0, 3));

        if (strlen($kodeNama) < 3) {
            $kodeNama = str_pad($kodeNama, 3, 'X');
        }

        $lastKode = self::where('kode_divisi', 'LIKE', 'DIV%')
            ->orderBy('created_at', 'desc')
            ->value('kode_divisi');

        $lastNumber = $lastKode
            ? intval(substr($lastKode, 3, 3))
            : 0;

        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        return "DIV{$newNumber}{$kodeNama}";
    }

    public static function createDivisi(array $data)
    {
        return self::create([
            'kantor_id'   => $data['kantor_id'],
            'nama_divisi' => $data['nama_divisi'],
            'deskripsi'   => $data['deskripsi'] ?? null,
            'status'      => $data['status'] ?? true,
        ]);
    }

    public function updateDivisi(array $data)
    {
        $this->update([
            'kantor_id'   => $data['kantor_id'],
            'nama_divisi' => $data['nama_divisi'],
            'deskripsi'   => $data['deskripsi'] ?? $this->deskripsi,
            'status'      => $data['status'] ?? $this->status,
        ]);
    }

    public function toggleStatus()
    {
        $this->status = !$this->status;
        $this->save();
    }
}
