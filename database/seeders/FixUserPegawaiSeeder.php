<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pegawai;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FixUserPegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pegawais = Pegawai::whereNull('user_id')->get();
        $role = Role::where('role_name', 'Pegawai')->first();

        if (!$role) {
            $role = Role::create([
                'id' => (string) Str::uuid(),
                'role_name' => 'Pegawai',
                'role_description' => 'Role Pegawai Biasa',
                'role_status' => true
            ]);
        }

        $count = 0;
        foreach ($pegawais as $pegawai) {
            // Password default: DDMMYYYY
            // Use tanggal_lahir if available, else default to '12345678'
            $dob = $pegawai->tanggal_lahir ? Carbon::parse($pegawai->tanggal_lahir)->format('dmY') : '12345678';
            $password = $dob;

            $email = $pegawai->email_pribadi ?? $pegawai->nip . '@hris.local';

            // Check if user with this email already exists
            $existingUser = User::where('email', $email)->first();

            if ($existingUser) {
                // Determine if we need to link it
                if (!$pegawai->user_id) {
                    $pegawai->user_id = $existingUser->id;
                    $pegawai->save();
                    $this->command->info("Linked Pegawai {$pegawai->nip} to existing User {$email}");
                }
            } else {
                $user = User::create([
                    'id' => (string) Str::uuid(),
                    'name' => $pegawai->nama_lengkap,
                    'email' => $email,
                    'password' => bcrypt($password),
                    'role_id' => $role->id,
                    'foto' => $pegawai->foto ?? null,
                    'status' => true,
                ]);

                $pegawai->user_id = $user->id;
                $pegawai->save();
                $count++;
                $this->command->info("Created User for Pegawai {$pegawai->nip} with password {$password}");
            }
        }

        $this->command->info("Total Users Created: $count");
    }
}
