<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Str;

class KandidatRoleSeeder extends Seeder
{
    public function run(): void
    {
        $roleName = 'Kandidat';
        $exists = Role::where('role_name', $roleName)->exists();

        if (!$exists) {
            Role::create([
                'id' => (string) Str::uuid(),
                'role_name' => $roleName,
                'role_description' => 'Calon Pegawai / Pelamar',
                'role_status' => true
            ]);
            $this->command->info('Role Kandidat created.');
        } else {
            $this->command->info('Role Kandidat already exists.');
        }
    }
}
