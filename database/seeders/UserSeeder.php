<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $admin = User::factory()->create([
        //     'name' => 'Admin User',
        //     'email' => 'admin@example.com',
        //     'password' => Hash::make('password'),
        // ]);

        // $user = User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'user@example.com',
        //     'password' => Hash::make('password'),
        // ]);

        // $admin->assignRole('admin');
        // $user->assignRole('user');

        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin.airways@yopmail.com',
                'password' => Hash::make('Admin@123'),
                'phone_code' => '+00',
                'phone_number' => '1234567890',
                'role'    => 'admin',
                'email_verified_at' => Carbon::now(),

            ],
            [
                'name' => 'Test User',
                'email' => 'user.airways@yopmail.com',
                'password' => Hash::make('User@123'),
                'phone_code' => '+00',
                'phone_number' => '1234567891',
                'role'    => 'user',
                'email_verified_at' => Carbon::now(),
            ]
        ];

        foreach ($users as $data) {
            $user = User::updateOrCreate([
                'email' => $data['email']
            ], [
                'name' => $data['name'],
                'password' => $data['password'],
                'phone_code' => $data['phone_code'],
                'phone_number' => $data['phone_number'],
                'email_verified_at' => $data['email_verified_at']
            ]);

            $user->syncRoles($data['role']);
        }
    }
}
