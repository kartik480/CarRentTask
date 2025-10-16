# 🚗 Laravel Car Rental System - Admin & Supplier Panel

A complete Laravel-based car rental management system with role-based authentication, featuring separate admin and supplier dashboards.

## 🌟 Features

### 🔐 Authentication & Roles
- **Role-based login**: Admin, Supplier, Customer
- **Secure authentication** with middleware protection
- **User registration** with validation
- **Profile management** with settings

### 👨‍💼 Admin Panel
- **Dashboard** with statistics (total cars, bookings, suppliers)
- **Supplier Management**: Add/Edit/Delete suppliers
- **Car Management**: Add/Edit/Delete car listings
- **Booking Management**: View and manage all bookings
- **Car Approval System**: Approve/reject cars added by suppliers

### 🚙 Supplier Panel
- **Dashboard** with supplier-specific statistics
- **Car Management**: Add/Edit/Delete own car listings
- **Booking Management**: View bookings for own cars
- **Availability Calendar**: Set and manage car availability
- **Booking Status Updates**: Confirm/Cancel/Complete bookings

### 🚗 Public Features
- **Car Listings**: Browse available cars
- **Car Details**: View car information and images
- **Booking System**: Book cars with date selection
- **Availability Check**: Prevent double bookings

### 📧 Notifications
- **Email notifications** for booking confirmations
- **Car approval notifications** for suppliers
- **New booking alerts** for suppliers

### 🔌 API Features
- **RESTful API** endpoints for cars and bookings
- **API Resources** for data transformation
- **Form Request validation**
- **Complete API documentation**

## 🚀 Installation

### Prerequisites
- PHP 8.2+
- Composer
- MySQL/MariaDB
- XAMPP/WAMP/LAMP

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/kartik480/CarRentTask.git
   cd CarRentTask
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
   - Create a MySQL database

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Seed test data**
   ```bash
   php artisan db:seed
   ```

7. **Start the server**
   ```bash
   php artisan serve
   ```

## 👥 Test Users

### Admin User
- **Email**: `admin@carrental.com`
- **Password**: `password`
- **Access**: Full admin panel

### Supplier Users
- **Email**: `john@supplier.com`
- **Password**: `password`
- **Access**: Supplier panel

- **Email**: `sarah@supplier.com`
- **Password**: `password`
- **Access**: Supplier panel

### Customer Users
- **Email**: `customer@example.com`
- **Password**: `password`
- **Access**: Public car listings

## 🎯 Access URLs

### Public Access
- **Home**: `http://127.0.0.1:8000`
- **Car Listings**: `http://127.0.0.1:8000/cars`
- **Login**: `http://127.0.0.1:8000/login`
- **Register**: `http://127.0.0.1:8000/register`

### Admin Panel
- **Dashboard**: `http://127.0.0.1:8000/admin/dashboard`
- **Manage Cars**: `http://127.0.0.1:8000/admin/cars`
- **Manage Suppliers**: `http://127.0.0.1:8000/admin/suppliers`
- **Manage Bookings**: `http://127.0.0.1:8000/admin/bookings`

### Supplier Panel
- **Dashboard**: `http://127.0.0.1:8000/supplier/dashboard`
- **My Cars**: `http://127.0.0.1:8000/supplier/cars`
- **My Bookings**: `http://127.0.0.1:8000/supplier/bookings`
- **Availability Calendar**: `http://127.0.0.1:8000/supplier/availability/calendar`

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AdminController.php
│   │   ├── SupplierController.php
│   │   ├── CarController.php
│   │   ├── ProfileController.php
│   │   └── Api/
│   ├── Middleware/
│   │   ├── AdminMiddleware.php
│   │   └── SupplierMiddleware.php
│   ├── Requests/
│   └── Resources/
├── Models/
│   ├── User.php
│   ├── Car.php
│   └── Booking.php
└── Notifications/

database/
├── migrations/
└── seeders/

resources/
├── views/
│   ├── admin/
│   ├── supplier/
│   ├── auth/
│   ├── cars/
│   └── layouts/
└── css/

routes/
├── web.php
└── api.php
```

## 🔧 Key Technologies

- **Laravel 11** - PHP Framework
- **MySQL** - Database
- **Bootstrap 5** - Frontend Framework
- **Font Awesome** - Icons
- **Laravel Notifications** - Email notifications
- **Eloquent ORM** - Database operations
- **Blade Templates** - View engine

## 📋 Database Schema

### Users Table
- `id`, `name`, `email`, `password`
- `role` (admin, supplier, customer)
- `phone`, `address`, `is_active`
- `notifications`, `email_notifications`

### Cars Table
- `id`, `name`, `type`, `location`
- `price_per_day`, `description`, `image`
- `seats`, `fuel_type`, `transmission`
- `is_available`, `status`, `supplier_id`

### Bookings Table
- `id`, `user_id`, `car_id`, `supplier_id`
- `start_date`, `end_date`, `total_days`
- `total_amount`, `total_price`, `status`
- `customer_name`, `customer_email`, `customer_phone`
- `notes`

## 🚀 API Endpoints

### Cars API
- `GET /api/cars` - List all cars
- `GET /api/cars/{id}` - Get car details
- `POST /api/cars` - Create car (Admin/Supplier)
- `PUT /api/cars/{id}` - Update car
- `DELETE /api/cars/{id}` - Delete car

### Bookings API
- `GET /api/bookings` - List bookings
- `POST /api/bookings` - Create booking
- `PUT /api/bookings/{id}` - Update booking status

## 📚 Documentation

- **API Documentation**: `API_DOCUMENTATION.md`
- **Panel Access Guide**: `PANEL_ACCESS_GUIDE.md`
- **Implementation Summary**: `IMPLEMENTATION_SUMMARY.md`

## 🐛 Troubleshooting

### Common Issues
1. **Database connection errors**: Check `.env` database credentials
2. **Permission errors**: Ensure storage and cache directories are writable
3. **Missing columns**: Run `php artisan migrate` to apply all migrations

### Debug Commands
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👨‍💻 Author

**Kartik**
- GitHub: [@kartik480](https://github.com/kartik480)
- Repository: [CarRentTask](https://github.com/kartik480/CarRentTask)

---

## 🎉 Project Status

✅ **Complete Laravel Car Rental System**
- ✅ Admin Panel with full CRUD operations
- ✅ Supplier Panel with car and booking management
- ✅ Public car listings and booking system
- ✅ Role-based authentication and authorization
- ✅ Email notifications system
- ✅ RESTful API with documentation
- ✅ Form validation and error handling
- ✅ Responsive Bootstrap UI
- ✅ Database migrations and seeders
- ✅ All bonus features implemented

**Ready for production deployment!** 🚀
