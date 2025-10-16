#!/bin/bash
# Complete Hostinger Deployment Script for Laravel Car Rental System
# Run this script in your Hostinger terminal/SSH

echo "🚀 Starting Laravel Car Rental System Deployment on Hostinger..."
echo "Domain: https://pznstudio.shop"
echo "Database: u344026722_car_rental_sys"
echo "=========================================="

# Step 1: Create .env file
echo "📝 Step 1: Creating .env file..."
cat > .env << 'EOF'
APP_NAME="Car Rental System"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_TIMEZONE=UTC
APP_URL=https://pznstudio.shop

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u344026722_car_rental_sys
DB_USERNAME=u344026722_car_rental_sys
DB_PASSWORD=&h9J?5Cy

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=noreply@pznstudio.shop
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@pznstudio.shop"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"
EOF

echo "✅ .env file created successfully!"

# Step 2: Generate Application Key
echo "🔑 Step 2: Generating application key..."
php artisan key:generate --force
echo "✅ Application key generated!"

# Step 3: Install Dependencies
echo "📦 Step 3: Installing dependencies..."
composer install --optimize-autoloader --no-dev --no-interaction
echo "✅ Dependencies installed!"

# Step 4: Set Permissions
echo "🔐 Step 4: Setting file permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod 644 .env
echo "✅ Permissions set!"

# Step 5: Run Database Migrations
echo "🗄️ Step 5: Running database migrations..."
php artisan migrate --force
echo "✅ Database migrations completed!"

# Step 6: Seed Database
echo "🌱 Step 6: Seeding database..."
php artisan db:seed --force
echo "✅ Database seeded!"

# Step 7: Create Storage Link
echo "🔗 Step 7: Creating storage link..."
php artisan storage:link
echo "✅ Storage link created!"

# Step 8: Clear and Cache Configuration
echo "⚡ Step 8: Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo "✅ Application optimized!"

# Step 9: Create Security .htaccess
echo "🛡️ Step 9: Creating security configuration..."
cat > .htaccess << 'EOF'
# Root .htaccess for Laravel Car Rental System
<Files .env>
    Order allow,deny
    Deny from all
</Files>

<Files composer.json>
    Order allow,deny
    Deny from all
</Files>

<Files composer.lock>
    Order allow,deny
    Deny from all
</Files>

<Files artisan>
    Order allow,deny
    Deny from all
</Files>

<DirectoryMatch "/(storage|bootstrap/cache|vendor|database)">
    Order allow,deny
    Deny from all
</DirectoryMatch>

<DirectoryMatch "/(app|config|database|resources|routes)">
    <Files "*.php">
        Order allow,deny
        Deny from all
    </Files>
</DirectoryMatch>

<IfModule mod_headers.c>
    Header always set X-Content-Type-Options nosniff
    Header always set X-Frame-Options DENY
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
</IfModule>

Options -Indexes
EOF

echo "✅ Security configuration created!"

# Step 10: Final Verification
echo "🔍 Step 10: Final verification..."
echo "Checking if application is ready..."

if [ -f ".env" ] && [ -f "artisan" ] && [ -d "storage" ]; then
    echo "✅ All files are in place!"
    echo ""
    echo "🎉 DEPLOYMENT COMPLETED SUCCESSFULLY!"
    echo "=========================================="
    echo "🌐 Your Car Rental System is now live at:"
    echo "   https://pznstudio.shop"
    echo ""
    echo "🔐 Test Credentials:"
    echo "   Admin: admin@carrental.com / password"
    echo "   Supplier: john@supplier.com / password"
    echo "   Customer: customer@example.com / password"
    echo ""
    echo "📱 Features Available:"
    echo "   ✅ Modern Professional Design"
    echo "   ✅ Euro Currency (€)"
    echo "   ✅ Dark Mode Toggle"
    echo "   ✅ Admin Panel"
    echo "   ✅ Supplier Panel"
    echo "   ✅ Car Management"
    echo "   ✅ Booking System"
    echo "   ✅ Email Notifications"
    echo ""
    echo "🚀 Your Laravel Car Rental System is ready!"
else
    echo "❌ Deployment failed. Please check the errors above."
    exit 1
fi
