<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'petugas', 'guard_name' => 'web']);

        $superAdmin = User::updateOrCreate(
            ['email' => 'admin@pemda.go.id'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('123'),
            ]
        );
        $superAdmin->assignRole('super_admin');

        $petugas = User::updateOrCreate(
            ['email' => 'petugas@pemda.go.id'],
            [
                'name' => 'Petugas Arsip',
                'password' => Hash::make('123'),
            ]
        );
        $petugas->assignRole('petugas');
    }
}
