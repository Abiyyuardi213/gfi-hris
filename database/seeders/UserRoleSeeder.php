<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Roles if not exist
        $roles = [
            ['name' => 'Super Admin', 'desc' => 'Full Access'],
            ['name' => 'Admin', 'desc' => 'Hanya Akses Module Tertentu'],
            ['name' => 'Pegawai', 'desc' => 'Akses Terbatas Pegawai'],
        ];

        foreach ($roles as $r) {
            $roleExists = Role::where('role_name', $r['name'])->first();
            if (!$roleExists) {
                Role::create([
                    'id' => (string) Str::uuid(),
                    'role_name' => $r['name'],
                    'role_description' => $r['desc'],
                    'role_status' => true
                ]);
            }
        }

        // 2. Create Super Admin User
        $superAdminRole = Role::where('role_name', 'Super Admin')->first();

        $email = 'admin@gfi.com';
        $user = User::where('email', $email)->first();

        if (!$user && $superAdminRole) {
            User::create([
                'id' => (string) Str::uuid(),
                'name' => 'Super Administrator',
                'email' => $email,
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // Default password
                'role_id' => $superAdminRole->id,
                'status' => true,
            ]);
            $this->command->info("User Admin created: $email / password");
        } else {
            $this->command->info("User Admin already exists.");
        }
    }
}
