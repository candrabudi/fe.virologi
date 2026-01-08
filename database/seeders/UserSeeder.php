<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        $admin = User::firstOrCreate(
            ['username' => 'admin'],
            [
                'email' => 'admin@rd-virologi.tech',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'active',
            ]
        );

        $admin->detail()->updateOrCreate(
            ['user_id' => $admin->id],
            [
                'full_name' => 'Administrator RD-Virologi',
                'phone_number' => '+62 21 555 0123',
            ]
        );

        // Editor
        $editor = User::firstOrCreate(
            ['username' => 'editor_one'],
            [
                'email' => 'editor@rd-virologi.tech',
                'password' => Hash::make('password'),
                'role' => 'editor',
                'status' => 'active',
            ]
        );

        $editor->detail()->updateOrCreate(
            ['user_id' => $editor->id],
            [
                'full_name' => 'Operational Editor',
                'phone_number' => '+62 21 555 0124',
            ]
        );

        // Regular User
        $user = User::firstOrCreate(
            ['username' => 'agent_zero'],
            [
                'email' => 'user@rd-virologi.tech',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'active',
            ]
        );

        $user->detail()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'full_name' => 'Research Agent',
                'phone_number' => '+62 21 555 0125',
            ]
        );
    }
}
