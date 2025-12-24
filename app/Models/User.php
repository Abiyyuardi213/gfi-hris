<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'foto',
        'role_id',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => 'boolean',
    ];

    /**
     * ======================
     * BOOT
     * ======================
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            if (!$user->id) {
                $user->id = (string) Str::uuid();
            }
        });

        // static::created(function ($user) {
        //     RiwayatAktivitasLog::add(
        //         'users', 'create', "Membuat user {$user->email}",
        //         optional(Auth::user())->id
        //     );
        // });

        // static::updated(function ($user) {
        //     RiwayatAktivitasLog::add(
        //         'users', 'update', "Memperbarui user {$user->email}",
        //         optional(Auth::user())->id
        //     );
        // });

        // static::deleted(function ($user) {
        //     RiwayatAktivitasLog::add(
        //         'users', 'delete', "Menghapus user {$user->email}",
        //         optional(Auth::user())->id
        //     );
        // });
    }

    /**
     * ======================
     * CUSTOM METHODS
     * ======================
     */

    public static function createUser($data)
    {
        return self::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
            'foto'     => $data['foto'] ?? null,
            'role_id'  => $data['role_id'],
            'status'   => $data['status'] ?? true,
        ]);
    }

    public function updateUser($data)
    {
        $this->update([
            'name'    => $data['name'] ?? $this->name,
            'email'   => $data['email'] ?? $this->email,
            'foto'    => $data['foto'] ?? $this->foto,
            'role_id' => $data['role_id'] ?? $this->role_id,
            'status'  => $data['status'] ?? $this->status,
        ]);

        if (!empty($data['password'])) {
            $this->update([
                'password' => bcrypt($data['password']),
            ]);
        }
    }

    public function toggleStatus()
    {
        $this->status = !$this->status;
        $this->save();

        // RiwayatAktivitasLog::add(
        //     'users', 'toggle_status', "Mengubah status user {$this->email}",
        //     optional(Auth::user())->id
        // );
    }

    public function deleteUser()
    {
        return $this->delete();
    }

    /**
     * ======================
     * RELATIONS
     * ======================
     */

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // public function pegawai()
    // {
    //     return $this->hasOne(Pegawai::class);
    // }
}
