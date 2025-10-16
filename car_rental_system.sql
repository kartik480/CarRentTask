-- Car Rental System Database
-- Created for Laravel Mini Car Rental System
-- Import this file into phpMyAdmin

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Create database (uncomment if needed)
-- CREATE DATABASE IF NOT EXISTS `car_rental_system` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE `car_rental_system`;

-- --------------------------------------------------------

-- Table structure for table `users`
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','supplier','customer') NOT NULL DEFAULT 'customer',
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Table structure for table `cars`
CREATE TABLE `cars` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `price_per_day` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cars_supplier_id_foreign` (`supplier_id`),
  CONSTRAINT `cars_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Table structure for table `bookings`
CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `car_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','cancelled','completed') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bookings_user_id_foreign` (`user_id`),
  KEY `bookings_car_id_foreign` (`car_id`),
  CONSTRAINT `bookings_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Table structure for table `password_reset_tokens`
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Table structure for table `sessions`
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Table structure for table `cache`
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Table structure for table `cache_locks`
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Table structure for table `jobs`
CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Table structure for table `job_batches`
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Table structure for table `failed_jobs`
CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Dumping data for table `users`
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `phone`, `address`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@carrental.com', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '+1-555-0100', '123 Admin Street, Admin City, AC 12345', NULL, '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(2, 'John Smith', 'john@supplier.com', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'supplier', '+1-555-0101', '456 Supplier Ave, Supplier City, SC 54321', NULL, '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(3, 'Sarah Johnson', 'sarah@supplier.com', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'supplier', '+1-555-0102', '789 Car Lane, Auto City, AC 67890', NULL, '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(4, 'Mike Wilson', 'mike@supplier.com', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'supplier', '+1-555-0103', '321 Vehicle Road, Motor City, MC 13579', NULL, '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(5, 'Alice Brown', 'alice@customer.com', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', '+1-555-0201', '100 Customer St, Customer City, CC 11111', NULL, '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(6, 'Bob Davis', 'bob@customer.com', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', '+1-555-0202', '200 Client Ave, Client City, CC 22222', NULL, '2024-01-01 00:00:00', '2024-01-01 00:00:00');

-- --------------------------------------------------------

-- Dumping data for table `cars`
INSERT INTO `cars` (`id`, `name`, `type`, `location`, `price_per_day`, `image`, `description`, `is_available`, `supplier_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Toyota Camry 2023', 'sedan', 'New York, NY', 45.00, NULL, 'Comfortable and reliable sedan perfect for city driving and long trips.', 1, 2, 'approved', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(2, 'Honda Civic 2023', 'sedan', 'Los Angeles, CA', 42.00, NULL, 'Fuel-efficient sedan with modern features and great handling.', 1, 2, 'approved', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(3, 'Ford Explorer 2023', 'suv', 'Chicago, IL', 75.00, NULL, 'Spacious SUV perfect for families and outdoor adventures.', 1, 3, 'approved', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(4, 'Chevrolet Tahoe 2023', 'suv', 'Miami, FL', 85.00, NULL, 'Large SUV with premium features and excellent towing capacity.', 1, 3, 'approved', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(5, 'BMW 3 Series 2023', 'sedan', 'San Francisco, CA', 95.00, NULL, 'Luxury sedan with sporty performance and premium interior.', 1, 4, 'approved', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(6, 'Mercedes C-Class 2023', 'sedan', 'Boston, MA', 105.00, NULL, 'Elegant luxury sedan with advanced technology and comfort.', 1, 4, 'approved', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(7, 'Toyota Prius 2023', 'hatchback', 'Seattle, WA', 38.00, NULL, 'Hybrid hatchback with excellent fuel economy and eco-friendly features.', 1, 2, 'approved', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(8, 'Nissan Altima 2023', 'sedan', 'Denver, CO', 48.00, NULL, 'Mid-size sedan with comfortable ride and modern technology.', 1, 3, 'approved', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(9, 'Audi A4 2023', 'sedan', 'Austin, TX', 88.00, NULL, 'Premium sedan with quattro all-wheel drive and luxury features.', 1, 4, 'pending', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(10, 'Tesla Model 3 2023', 'sedan', 'Portland, OR', 120.00, NULL, 'Electric sedan with autopilot features and long range.', 0, 2, 'approved', '2024-01-01 00:00:00', '2024-01-01 00:00:00');

-- --------------------------------------------------------

-- Dumping data for table `bookings`
INSERT INTO `bookings` (`id`, `user_id`, `car_id`, `start_date`, `end_date`, `total_amount`, `status`, `notes`, `customer_name`, `customer_email`, `customer_phone`, `created_at`, `updated_at`) VALUES
(1, 5, 1, '2024-01-15', '2024-01-18', 135.00, 'confirmed', 'Need GPS navigation', 'Alice Brown', 'alice@customer.com', '+1-555-0201', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(2, 6, 2, '2024-01-20', '2024-01-22', 84.00, 'pending', 'Airport pickup required', 'Bob Davis', 'bob@customer.com', '+1-555-0202', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(3, 5, 3, '2024-01-25', '2024-01-30', 375.00, 'confirmed', 'Family vacation trip', 'Alice Brown', 'alice@customer.com', '+1-555-0201', '2024-01-01 00:00:00', '2024-01-01 00:00:00');

-- --------------------------------------------------------

-- Dumping data for table `migrations`
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_000001_create_cars_table', 1),
(5, '2024_01_01_000002_create_bookings_table', 1);

COMMIT;
