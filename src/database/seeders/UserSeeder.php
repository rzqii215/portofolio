<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'super_admin',
            'admin',
            'mahasiswa',
        ];

        foreach ($roles as $role) {
            Role::query()->firstOrCreate([
                'name' => $role,
                'guard_name' => 'web',
            ]);
        }

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $mahasiswaSatu = User::query()->updateOrCreate(
            ['email' => 'rizqi@example.com'],
            [
                'name' => 'Muhamad Rizqi Candra',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $mahasiswaDua = User::query()->updateOrCreate(
            ['email' => 'bima@example.com'],
            [
                'name' => 'Bima Pratama Wijaya',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $admin->syncRoles(['super_admin', 'admin']);
        $mahasiswaSatu->syncRoles(['mahasiswa']);
        $mahasiswaDua->syncRoles(['mahasiswa']);
    }
}