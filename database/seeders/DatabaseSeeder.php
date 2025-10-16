<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Car;
use App\Models\Booking;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@carrental.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+1-555-0100',
            'address' => '123 Admin Street, Admin City, AC 12345',
        ]);

        // Create supplier users
        $supplier1 = User::create([
            'name' => 'John Smith',
            'email' => 'john@supplier.com',
            'password' => Hash::make('password'),
            'role' => 'supplier',
            'phone' => '+1-555-0101',
            'address' => '456 Supplier Ave, Supplier City, SC 54321',
        ]);

        $supplier2 = User::create([
            'name' => 'Sarah Johnson',
            'email' => 'sarah@supplier.com',
            'password' => Hash::make('password'),
            'role' => 'supplier',
            'phone' => '+1-555-0102',
            'address' => '789 Car Lane, Auto City, AC 67890',
        ]);

        $supplier3 = User::create([
            'name' => 'Mike Wilson',
            'email' => 'mike@supplier.com',
            'password' => Hash::make('password'),
            'role' => 'supplier',
            'phone' => '+1-555-0103',
            'address' => '321 Vehicle Road, Motor City, MC 13579',
        ]);

        // Create customer users
        User::create([
            'name' => 'Alice Brown',
            'email' => 'alice@customer.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '+1-555-0201',
            'address' => '100 Customer St, Customer City, CC 11111',
        ]);

        User::create([
            'name' => 'Bob Davis',
            'email' => 'bob@customer.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '+1-555-0202',
            'address' => '200 Client Ave, Client City, CC 22222',
        ]);

        // Create cars
        $cars = [
            [
                'name' => 'Toyota Camry 2023',
                'type' => 'sedan',
                'location' => 'New York, NY',
                'price_per_day' => 45.00,
                'description' => 'Comfortable and reliable sedan perfect for city driving and long trips.',
                'supplier_id' => $supplier1->id,
                'status' => 'approved',
                'is_available' => true,
            ],
            [
                'name' => 'Honda Civic 2023',
                'type' => 'sedan',
                'location' => 'Los Angeles, CA',
                'price_per_day' => 42.00,
                'description' => 'Fuel-efficient sedan with modern features and great handling.',
                'supplier_id' => $supplier1->id,
                'status' => 'approved',
                'is_available' => true,
            ],
            [
                'name' => 'Ford Explorer 2023',
                'type' => 'suv',
                'location' => 'Chicago, IL',
                'price_per_day' => 75.00,
                'description' => 'Spacious SUV perfect for families and outdoor adventures.',
                'supplier_id' => $supplier2->id,
                'status' => 'approved',
                'is_available' => true,
            ],
            [
                'name' => 'Chevrolet Tahoe 2023',
                'type' => 'suv',
                'location' => 'Miami, FL',
                'price_per_day' => 85.00,
                'description' => 'Large SUV with premium features and excellent towing capacity.',
                'supplier_id' => $supplier2->id,
                'status' => 'approved',
                'is_available' => true,
            ],
            [
                'name' => 'BMW 3 Series 2023',
                'type' => 'sedan',
                'location' => 'San Francisco, CA',
                'price_per_day' => 95.00,
                'description' => 'Luxury sedan with sporty performance and premium interior.',
                'supplier_id' => $supplier3->id,
                'status' => 'approved',
                'is_available' => true,
            ],
            [
                'name' => 'Mercedes C-Class 2023',
                'type' => 'sedan',
                'location' => 'Boston, MA',
                'price_per_day' => 105.00,
                'description' => 'Elegant luxury sedan with advanced technology and comfort.',
                'supplier_id' => $supplier3->id,
                'status' => 'approved',
                'is_available' => true,
            ],
            [
                'name' => 'Toyota Prius 2023',
                'type' => 'hatchback',
                'location' => 'Seattle, WA',
                'price_per_day' => 38.00,
                'description' => 'Hybrid hatchback with excellent fuel economy and eco-friendly features.',
                'supplier_id' => $supplier1->id,
                'status' => 'approved',
                'is_available' => true,
            ],
            [
                'name' => 'Nissan Altima 2023',
                'type' => 'sedan',
                'location' => 'Denver, CO',
                'price_per_day' => 48.00,
                'description' => 'Mid-size sedan with comfortable ride and modern technology.',
                'supplier_id' => $supplier2->id,
                'status' => 'approved',
                'is_available' => true,
            ],
            [
                'name' => 'Audi A4 2023',
                'type' => 'sedan',
                'location' => 'Austin, TX',
                'price_per_day' => 88.00,
                'description' => 'Premium sedan with quattro all-wheel drive and luxury features.',
                'supplier_id' => $supplier3->id,
                'status' => 'pending',
                'is_available' => true,
            ],
            [
                'name' => 'Tesla Model 3 2023',
                'type' => 'sedan',
                'location' => 'Portland, OR',
                'price_per_day' => 120.00,
                'description' => 'Electric sedan with autopilot features and long range.',
                'supplier_id' => $supplier1->id,
                'status' => 'approved',
                'is_available' => false,
            ],
        ];

        foreach ($cars as $carData) {
            Car::create($carData);
        }

        // Create some sample bookings
        $car1 = Car::where('name', 'Toyota Camry 2023')->first();
        $car2 = Car::where('name', 'Honda Civic 2023')->first();
        $car3 = Car::where('name', 'Ford Explorer 2023')->first();

        Booking::create([
            'user_id' => User::where('email', 'alice@customer.com')->first()->id,
            'car_id' => $car1->id,
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(8),
            'total_amount' => 135.00,
            'status' => 'confirmed',
            'customer_name' => 'Alice Brown',
            'customer_email' => 'alice@customer.com',
            'customer_phone' => '+1-555-0201',
            'notes' => 'Need GPS navigation',
        ]);

        Booking::create([
            'user_id' => User::where('email', 'bob@customer.com')->first()->id,
            'car_id' => $car2->id,
            'start_date' => now()->addDays(10),
            'end_date' => now()->addDays(12),
            'total_amount' => 84.00,
            'status' => 'pending',
            'customer_name' => 'Bob Davis',
            'customer_email' => 'bob@customer.com',
            'customer_phone' => '+1-555-0202',
            'notes' => 'Airport pickup required',
        ]);

        Booking::create([
            'user_id' => User::where('email', 'alice@customer.com')->first()->id,
            'car_id' => $car3->id,
            'start_date' => now()->addDays(15),
            'end_date' => now()->addDays(20),
            'total_amount' => 375.00,
            'status' => 'confirmed',
            'customer_name' => 'Alice Brown',
            'customer_email' => 'alice@customer.com',
            'customer_phone' => '+1-555-0201',
            'notes' => 'Family vacation trip',
        ]);
    }
}