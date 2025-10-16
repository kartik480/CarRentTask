# Mini Car Rental System (Laravel)

A comprehensive car rental system with Admin and Supplier panels built with Laravel 12.

## Features

### Core Features
- **Role-based Authentication**: Admin, Supplier, and Customer roles
- **Admin Panel**: 
  - Dashboard with statistics
  - Manage suppliers (CRUD operations)
  - Approve/reject car listings
  - View and manage all bookings
- **Supplier Panel**:
  - Dashboard with personal statistics
  - Add/edit/delete car listings
  - View bookings for their cars
  - Check availability calendar
- **Public Car Listings**:
  - Browse available cars
  - Search and filter functionality
  - Car booking system
  - Availability checking

### Technical Features
- **REST API**: Complete API endpoints for car listings and bookings
- **Form Validation**: Custom Form Request classes
- **API Resources**: Structured API responses
- **Middleware**: Role-based access control
- **Database**: MySQL with proper relationships
- **File Upload**: Car image uploads
- **Responsive Design**: Bootstrap-based UI

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd laravel-master
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database configuration**
   - Update `.env` file with your database credentials
   - Create a MySQL database named `car_rental_system`

5. **Run migrations and seeders**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Create storage link**
   ```bash
   php artisan storage:link
   ```

7. **Start the development server**
   ```bash
   php artisan serve
   ```

## Default Login Credentials

### Admin
- **Email**: admin@carrental.com
- **Password**: password

### Suppliers
- **Email**: john@supplier.com
- **Password**: password
- **Email**: sarah@supplier.com
- **Password**: password
- **Email**: mike@supplier.com
- **Password**: password

### Customers
- **Email**: alice@customer.com
- **Password**: password
- **Email**: bob@customer.com
- **Password**: password

## API Documentation

### Base URL
```
http://localhost:8000/api/v1
```

### Public Endpoints

#### Get All Cars
```http
GET /cars
```

**Query Parameters:**
- `search` - Search by car name, location, or type
- `type` - Filter by car type (sedan, suv, hatchback, etc.)
- `location` - Filter by location
- `min_price` - Minimum price per day
- `max_price` - Maximum price per day
- `per_page` - Number of results per page (default: 12)

**Response:**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Toyota Camry 2023",
      "type": "sedan",
      "location": "New York, NY",
      "price_per_day": 45.00,
      "image_url": "http://localhost:8000/storage/cars/image.jpg",
      "description": "Comfortable and reliable sedan...",
      "is_available": true,
      "status": "approved",
      "supplier": {
        "id": 2,
        "name": "John Smith",
        "email": "john@supplier.com",
        "phone": "+1-555-0101"
      },
      "created_at": "2024-01-01T00:00:00.000000Z",
      "updated_at": "2024-01-01T00:00:00.000000Z"
    }
  ],
  "links": {...},
  "meta": {...}
}
```

#### Get Single Car
```http
GET /cars/{id}
```

#### Check Car Availability
```http
POST /cars/{id}/check-availability
```

**Request Body:**
```json
{
  "start_date": "2024-01-15",
  "end_date": "2024-01-18"
}
```

**Response:**
```json
{
  "available": true,
  "days": 4,
  "total_amount": 180.00,
  "message": "Car is available for the selected dates."
}
```

#### Book a Car
```http
POST /cars/{id}/book
```

**Request Body:**
```json
{
  "start_date": "2024-01-15",
  "end_date": "2024-01-18",
  "customer_name": "John Doe",
  "customer_email": "john@example.com",
  "customer_phone": "+1-555-0123",
  "notes": "Airport pickup required"
}
```

### Protected Endpoints (Require Authentication)

#### Get User's Bookings
```http
GET /bookings
Authorization: Bearer {token}
```

#### Get Single Booking
```http
GET /bookings/{id}
Authorization: Bearer {token}
```

#### Cancel Booking
```http
POST /bookings/{id}/cancel
Authorization: Bearer {token}
```

## Database Schema

### Users Table
- `id` - Primary key
- `name` - User's full name
- `email` - Unique email address
- `password` - Hashed password
- `role` - Enum: admin, supplier, customer
- `phone` - Phone number (nullable)
- `address` - Address (nullable)
- `timestamps`

### Cars Table
- `id` - Primary key
- `name` - Car name/model
- `type` - Car type (sedan, suv, etc.)
- `location` - Car location
- `price_per_day` - Daily rental price
- `image` - Image file path (nullable)
- `description` - Car description (nullable)
- `is_available` - Boolean availability flag
- `supplier_id` - Foreign key to users table
- `status` - Enum: pending, approved, rejected
- `timestamps`

### Bookings Table
- `id` - Primary key
- `user_id` - Foreign key to users table (nullable for guest bookings)
- `car_id` - Foreign key to cars table
- `start_date` - Booking start date
- `end_date` - Booking end date
- `total_amount` - Total booking amount
- `status` - Enum: pending, confirmed, cancelled, completed
- `notes` - Special requests (nullable)
- `customer_name` - Customer's name
- `customer_email` - Customer's email
- `customer_phone` - Customer's phone
- `timestamps`

## File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Api/
│   │   │   ├── CarApiController.php
│   │   │   └── BookingApiController.php
│   │   ├── AdminController.php
│   │   ├── AuthController.php
│   │   ├── BookingController.php
│   │   ├── CarController.php
│   │   └── SupplierController.php
│   ├── Middleware/
│   │   ├── AdminMiddleware.php
│   │   └── SupplierMiddleware.php
│   ├── Requests/
│   │   ├── StoreBookingRequest.php
│   │   ├── StoreCarRequest.php
│   │   ├── StoreSupplierRequest.php
│   │   ├── UpdateCarRequest.php
│   │   └── UpdateSupplierRequest.php
│   └── Resources/
│       ├── BookingResource.php
│       └── CarResource.php
├── Models/
│   ├── Booking.php
│   ├── Car.php
│   └── User.php
database/
├── migrations/
│   ├── 0001_01_01_000000_create_users_table.php
│   ├── 2024_01_01_000001_create_cars_table.php
│   └── 2024_01_01_000002_create_bookings_table.php
└── seeders/
    └── DatabaseSeeder.php
resources/
└── views/
    ├── admin/
    │   └── dashboard.blade.php
    ├── auth/
    │   ├── login.blade.php
    │   └── register.blade.php
    ├── cars/
    │   ├── index.blade.php
    │   └── show.blade.php
    ├── layouts/
    │   └── app.blade.php
    └── supplier/
        └── dashboard.blade.php
routes/
├── api.php
└── web.php
```

## Usage

1. **Admin Panel** (`/admin/dashboard`):
   - View system statistics
   - Manage suppliers
   - Approve/reject car listings
   - Monitor all bookings

2. **Supplier Panel** (`/supplier/dashboard`):
   - View personal statistics
   - Manage car listings
   - Handle booking requests
   - Check car availability

3. **Public Interface** (`/cars`):
   - Browse available cars
   - Search and filter cars
   - Book cars
   - Check availability

## Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).