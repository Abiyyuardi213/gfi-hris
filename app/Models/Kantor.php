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
        'tipe_kantor',
        'no_telp',
        'email',
        'kota_id',
        'alamat',
        'latitude',
        'longitude',
        'radius',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'latitude' => 'double',
        'longitude' => 'double',
        'radius' => 'integer',
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
            'tipe_kantor' => $data['tipe_kantor'] ?? 'Cabang',
            'no_telp'     => $data['no_telp'] ?? null,
            'email'       => $data['email'] ?? null,
            'kota_id'     => $data['kota_id'] ?? null,
            'alamat'      => $data['alamat'] ?? null,
            'latitude'    => $data['latitude'] ?? null,
            'longitude'   => $data['longitude'] ?? null,
            'radius'      => $data['radius'] ?? 100,
            'status'      => $data['status'] ?? true,
        ]);
    }

    public function updateKantor(array $data)
    {
        $this->update([
            'nama_kantor' => $data['nama_kantor'],
            'tipe_kantor' => $data['tipe_kantor'] ?? $this->tipe_kantor,
            'no_telp'     => $data['no_telp'] ?? $this->no_telp,
            'email'       => $data['email'] ?? $this->email,
            'kota_id'     => $data['kota_id'] ?? $this->kota_id,
            'alamat'      => $data['alamat'] ?? $this->alamat,
            'latitude'    => $data['latitude'] ?? $this->latitude,
            'longitude'   => $data['longitude'] ?? $this->longitude,
            'radius'      => $data['radius'] ?? $this->radius,
            'status'      => $data['status'] ?? $this->status,
        ]);
    }

    public function toggleStatus()
    {
        $this->status = !$this->status;
        $this->save();
    }

    // Relations
    public function kota()
    {
        return $this->belongsTo(Kota::class, 'kota_id');
    }
}
