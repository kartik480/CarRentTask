<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateTestUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test user for login testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'phone' => '1234567890',
            'address' => 'Test Address',
            'is_active' => 1,
        ]);

        $this->info('Test user created successfully!');
        $this->line('Email: test@test.com');
        $this->line('Password: password123');
        $this->line('User ID: ' . $user->id);
    }
}
