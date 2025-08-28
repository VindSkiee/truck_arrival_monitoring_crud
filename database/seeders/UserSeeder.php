<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'username' => 'cs',
                'password' => Hash::make('password123'),
                'role' => 'cs',
            ],
            [
                'username' => 'security',
                'password' => Hash::make('password123'),
                'role' => 'security',
            ],
            [
                'username' => 'warehouse',
                'password' => Hash::make('password123'),
                'role' => 'warehouse',
            ],
            [
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ],
        ];

        DB::table('users')->insert($users);
    }
}
