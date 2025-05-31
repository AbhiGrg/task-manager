<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create([ 'name' => 'admin']);
        $userRole = Role::create([ 'name' => 'user']);

        $admin = User::first();
        $admin->assignRole($adminRole);
    }
}
