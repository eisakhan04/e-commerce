<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Admin Role if not exists
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);

        // 2. Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'phone' => '03001234567',
                'password' => Hash::make('11223344'),
            ]
        );

        // 3. Assign Role
        $admin->assignRole($adminRole);

        $this->command->info('Admin user created successfully.');
        $this->command->info('Email: admin@example.com');
        $this->command->info('Phone: 03001234567');
        $this->command->info('Password: 11223344');
    }
}
