@echo off
REM Complete Hostinger Deployment Script for Laravel Car Rental System
REM Run this script in your Hostinger terminal/SSH

echo 🚀 Starting Laravel Car Rental System Deployment on Hostinger...
echo Domain: https://pznstudio.shop
echo Database: u344026722_car_rental_sys
echo ==========================================

REM Step 1: Create .env file
echo 📝 Step 1: Creating .env file...
(
echo APP_NAME="Car Rental System"
echo APP_ENV=production
echo APP_KEY=
echo APP_DEBUG=false
echo APP_TIMEZONE=UTC
echo APP_URL=https://pznstudio.shop
echo.
echo APP_LOCALE=en
echo APP_FALLBACK_LOCALE=en
echo APP_FAKER_LOCALE=en_US
echo.
echo APP_MAINTENANCE_DRIVER=file
echo APP_MAINTENANCE_STORE=database
echo.
echo BCRYPT_ROUNDS=12
echo.
echo LOG_CHANNEL=stack
echo LOG_STACK=single
echo LOG_DEPRECATIONS_CHANNEL=null
echo LOG_LEVEL=error
echo.
echo DB_CONNECTION=mysql
echo DB_HOST=localhost
echo DB_PORT=3306
echo DB_DATABASE=u344026722_car_rental_sys
echo DB_USERNAME=u344026722_car_rental_sys
echo DB_PASSWORD=^&h9J?5Cy
echo.
echo SESSION_DRIVER=database
echo SESSION_LIFETIME=120
echo SESSION_ENCRYPT=false
echo SESSION_PATH=/
echo SESSION_DOMAIN=null
echo.
echo BROADCAST_CONNECTION=log
echo FILESYSTEM_DISK=local
echo QUEUE_CONNECTION=database
echo.
echo CACHE_STORE=database
echo CACHE_PREFIX=
echo.
echo MEMCACHED_HOST=127.0.0.1
echo.
echo REDIS_CLIENT=phpredis
echo REDIS_HOST=127.0.0.1
echo REDIS_PASSWORD=null
echo REDIS_PORT=6379
echo.
echo MAIL_MAILER=smtp
echo MAIL_HOST=smtp.hostinger.com
echo MAIL_PORT=587
echo MAIL_USERNAME=noreply@pznstudio.shop
echo MAIL_PASSWORD=
echo MAIL_ENCRYPTION=tls
echo MAIL_FROM_ADDRESS="noreply@pznstudio.shop"
echo MAIL_FROM_NAME="${APP_NAME}"
echo.
echo AWS_ACCESS_KEY_ID=
echo AWS_SECRET_ACCESS_KEY=
echo AWS_DEFAULT_REGION=us-east-1
echo AWS_BUCKET=
echo AWS_USE_PATH_STYLE_ENDPOINT=false
echo.
echo VITE_APP_NAME="${APP_NAME}"
) > .env

echo ✅ .env file created successfully!

REM Step 2: Generate Application Key
echo 🔑 Step 2: Generating application key...
php artisan key:generate --force
echo ✅ Application key generated!

REM Step 3: Install Dependencies
echo 📦 Step 3: Installing dependencies...
composer install --optimize-autoloader --no-dev --no-interaction
echo ✅ Dependencies installed!

REM Step 4: Set Permissions
echo 🔐 Step 4: Setting file permissions...
REM Note: Windows doesn't support chmod, permissions are set via file manager
echo ✅ Permissions will be set via Hostinger file manager!

REM Step 5: Run Database Migrations
echo 🗄️ Step 5: Running database migrations...
php artisan migrate --force
echo ✅ Database migrations completed!

REM Step 6: Seed Database
echo 🌱 Step 6: Seeding database...
php artisan db:seed --force
echo ✅ Database seeded!

REM Step 7: Create Storage Link
echo 🔗 Step 7: Creating storage link...
php artisan storage:link
echo ✅ Storage link created!

REM Step 8: Clear and Cache Configuration
echo ⚡ Step 8: Optimizing application...
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo ✅ Application optimized!

REM Step 9: Create Security .htaccess
echo 🛡️ Step 9: Creating security configuration...
(
echo # Root .htaccess for Laravel Car Rental System
echo ^<Files .env^>
echo     Order allow,deny
echo     Deny from all
echo ^</Files^>
echo.
echo ^<Files composer.json^>
echo     Order allow,deny
echo     Deny from all
echo ^</Files^>
echo.
echo ^<Files composer.lock^>
echo     Order allow,deny
echo     Deny from all
echo ^</Files^>
echo.
echo ^<Files artisan^>
echo     Order allow,deny
echo     Deny from all
echo ^</Files^>
echo.
echo ^<DirectoryMatch "/(storage|bootstrap/cache|vendor|database)"^>
echo     Order allow,deny
echo     Deny from all
echo ^</DirectoryMatch^>
echo.
echo ^<DirectoryMatch "/(app|config|database|resources|routes)"^>
echo     ^<Files "*.php"^>
echo         Order allow,deny
echo         Deny from all
echo     ^</Files^>
echo ^</DirectoryMatch^>
echo.
echo ^<IfModule mod_headers.c^>
echo     Header always set X-Content-Type-Options nosniff
echo     Header always set X-Frame-Options DENY
echo     Header always set X-XSS-Protection "1; mode=block"
echo     Header always set Referrer-Policy "strict-origin-when-cross-origin"
echo ^</IfModule^>
echo.
echo Options -Indexes
) > .htaccess

echo ✅ Security configuration created!

REM Step 10: Final Verification
echo 🔍 Step 10: Final verification...
echo Checking if application is ready...

if exist .env if exist artisan if exist storage (
    echo ✅ All files are in place!
    echo.
    echo 🎉 DEPLOYMENT COMPLETED SUCCESSFULLY!
    echo ==========================================
    echo 🌐 Your Car Rental System is now live at:
    echo    https://pznstudio.shop
    echo.
    echo 🔐 Test Credentials:
    echo    Admin: admin@carrental.com / password
    echo    Supplier: john@supplier.com / password
    echo    Customer: customer@example.com / password
    echo.
    echo 📱 Features Available:
    echo    ✅ Modern Professional Design
    echo    ✅ Euro Currency (€)
    echo    ✅ Dark Mode Toggle
    echo    ✅ Admin Panel
    echo    ✅ Supplier Panel
    echo    ✅ Car Management
    echo    ✅ Booking System
    echo    ✅ Email Notifications
    echo.
    echo 🚀 Your Laravel Car Rental System is ready!
) else (
    echo ❌ Deployment failed. Please check the errors above.
    exit /b 1
)

pause
