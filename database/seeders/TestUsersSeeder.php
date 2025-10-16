<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@carrental.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+1234567890',
            'address' => '123 Admin Street, Admin City',
            'is_active' => 1,
        ]);

        // Create Supplier Users
        User::create([
            'name' => 'John Supplier',
            'email' => 'john@supplier.com',
            'password' => Hash::make('password'),
            'role' => 'supplier',
            'phone' => '+1234567891',
            'address' => '456 Supplier Avenue, Supplier City',
            'is_active' => 1,
        ]);

        User::create([
            'name' => 'Sarah Supplier',
            'email' => 'sarah@supplier.com',
            'password' => Hash::make('password'),
            'role' => 'supplier',
            'phone' => '+1234567892',
            'address' => '789 Supplier Road, Supplier Town',
            'is_active' => 1,
        ]);

        // Create Customer Users
        User::create([
            'name' => 'Customer One',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '+1234567893',
            'address' => '321 Customer Lane, Customer City',
            'is_active' => 1,
        ]);

        User::create([
            'name' => 'Customer Two',
            'email' => 'customer2@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '+1234567894',
            'address' => '654 Customer Street, Customer Town',
            'is_active' => 1,
        ]);
    }
}
