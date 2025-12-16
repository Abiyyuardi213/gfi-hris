<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kantor extends Model
{
    protected $table = 'kantor';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'nama_kantor',
        'alamat',
        'status',
    ];

    protected static function booted()
    {
        static::creating(function ($kantor) {
            if (!$kantor->id) {
                $kantor->id = (string) Str::uuid();
            }

            if (!$kantor->kode_kantor) {
                $kantor->kode_kantor = self::generateKodeKantor($kantor->nama_kantor);
            }
        });
    }

    protected static function generateKodeKantor(string $namaKantor): string
    {
        $kodeKota = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $namaKantor), 0, 3));

        if (strlen($kodeKota) < 3) {
            $kodeKota = str_pad($kodeKota, 3, 'X');
        }

        $lastKode = self::where('kode_kantor', 'LIKE', 'OFF%')
            ->orderBy('created_at', 'desc')
            ->value('kode_kantor');

        $lastNumber = $lastKode
            ? intval(substr($lastKode, 3, 3))
            : 0;

        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        return "OFF{$newNumber}{$kodeKota}";
    }

    public static function createKantor(array $data)
    {
        return self::create([
            'nama_kantor' => $data['nama_kantor'],
            'alamat'      => $data['alamat'] ?? null,
            'status'      => $data['status'] ?? true,
        ]);
    }

    public function updateKantor(array $data)
    {
        $this->update([
            'nama_kantor' => $data['nama_kantor'],
            'alamat'      => $data['alamat'] ?? $this->alamat,
            'status'      => $data['status'] ?? $this->status,
        ]);
    }

    public function toggleStatus()
    {
        $this->status = !$this->status;
        $this->save();
    }
}
