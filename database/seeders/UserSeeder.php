<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('secret123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Supervisor',
            'email' => 'supervisor@example.com',
            'password' => Hash::make('secret123'),
            'role' => 'supervisor',
        ]);

        User::create([
            'name' => 'E-commerce',
            'email' => 'e-commerce@example.com',
            'password' => Hash::make('secret123'),
            'role' => 'user', // or 'customer' if you change your role naming
        ]);
         User::create([
            'name' => 'Test',
            'email' => 'test@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'user', // or 'customer' if you change your role naming
        ]);
    }
    }

