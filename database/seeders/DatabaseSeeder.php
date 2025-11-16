<?php

namespace Database\Seeders;

use App\Enum\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create the super admin user.
        $superAdmin = User::create([
            'name' => config('fuse.super_admin.name'),
            'email' => config('fuse.super_admin.email'),
            'password' => Hash::make(config('fuse.super_admin.password')),
            'email_verified_at' => now(),
        ]);
        $superAdmin->assignRole(Role::ADMIN);

        // Create 10 more users, 3 with admin roles, others with editor roles.
        for ($i = 0; $i < 10; $i++) {
            $user = User::factory()->create();
            $user->assignRole($i % 3 === 0 ? Role::ADMIN : Role::EDITOR);
        }
    }
}
