<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'petugas', 'guard_name' => 'web']);

        $superAdmin = User::first();
        if ($superAdmin) {
            $superAdmin->assignRole('super_admin');
        }
    }
}
