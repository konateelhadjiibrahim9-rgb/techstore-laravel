<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'superadmin@techstore.ci'],
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@techstore.ci',
                'password' => bcrypt('admin123'),
                'role' => 'super_admin',
            ]
        );
    }
}
