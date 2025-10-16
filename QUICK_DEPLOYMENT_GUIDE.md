# 🚀 COMPLETE HOSTINGER DEPLOYMENT GUIDE
## Laravel Car Rental System - https://pznstudio.shop

### 📋 **QUICK DEPLOYMENT STEPS**

#### **Step 1: Access Hostinger Terminal/SSH**
1. Login to Hostinger control panel
2. Go to **Advanced** → **Terminal** (or SSH)
3. Navigate to your project directory: `cd public_html`

#### **Step 2: Run Deployment Commands**
Copy and paste these commands one by one:

```bash
# Create .env file
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
```

```bash
# Generate application key
php artisan key:generate --force
```

```bash
# Install dependencies
composer install --optimize-autoloader --no-dev --no-interaction
```

```bash
# Set permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod 644 .env
```

```bash
# Run database migrations
php artisan migrate --force
```

```bash
# Seed database with test data
php artisan db:seed --force
```

```bash
# Create storage link
php artisan storage:link
```

```bash
# Optimize application
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### **Step 3: Create Security .htaccess**
```bash
cat > .htaccess << 'EOF'
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
```

### 🎉 **DEPLOYMENT COMPLETE!**

#### **🌐 Your Website is Live:**
- **URL**: https://pznstudio.shop
- **Admin Panel**: https://pznstudio.shop/admin/dashboard
- **Supplier Panel**: https://pznstudio.shop/supplier/dashboard

#### **🔐 Test Credentials:**
- **Admin**: `admin@carrental.com` / `password`
- **Supplier**: `john@supplier.com` / `password`
- **Customer**: `customer@example.com` / `password`

#### **✨ Features Available:**
- ✅ Modern Professional Design
- ✅ Euro Currency (€)
- ✅ Dark Mode Toggle
- ✅ Admin Panel
- ✅ Supplier Panel
- ✅ Car Management
- ✅ Booking System
- ✅ Email Notifications
- ✅ Responsive Design
- ✅ Security Headers

### 🛠️ **Optional: SSL Certificate**
1. Go to Hostinger control panel
2. **Security** → **SSL**
3. Enable SSL certificate for `pznstudio.shop`

### 📧 **Email Configuration (Optional)**
If you want to send emails:
1. Go to Hostinger control panel
2. **Email** → **Email Accounts**
3. Create email: `noreply@pznstudio.shop`
4. Update `.env` with email password

---

**🚀 Your Laravel Car Rental System is now live and ready to use!**
