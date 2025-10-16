# 🚀 Hostinger Deployment Guide for Laravel Car Rental System

## 📋 Pre-Deployment Checklist

### 1. **Hostinger Requirements**
- ✅ PHP 8.2+ (Hostinger supports this)
- ✅ MySQL Database
- ✅ Composer support
- ✅ SSH access (recommended)

### 2. **Database Setup**
Your database credentials are already configured:
- **Database Name**: `u344026722_car_rental_sys`
- **Username**: `u344026722_car_rental_sys`
- **Password**: `&h9J?5Cy`
- **Host**: `localhost`

## 🔧 Deployment Steps

### Step 1: Upload Files to Hostinger
1. **Via File Manager** (Recommended):
   - Login to Hostinger control panel
   - Go to File Manager
   - Navigate to `public_html` folder
   - Upload all project files EXCEPT:
     - `.env` file
     - `storage/logs` folder
     - `vendor` folder (will be installed via Composer)

2. **Via FTP/SFTP**:
   - Use FTP client like FileZilla
   - Upload all files to `public_html` directory

### Step 2: Create .env File
1. Copy the contents from `HOSTINGER_CONFIG.env` file
2. Create a new `.env` file in your project root
3. Update the following values:
   ```env
   APP_URL=https://pznstudio.shop
   APP_KEY=base64:your-generated-key
   MAIL_FROM_ADDRESS="noreply@pznstudio.shop"
   ```

### Step 3: Generate Application Key
Run this command in Hostinger terminal or via SSH:
```bash
php artisan key:generate
```

### Step 4: Install Dependencies
```bash
composer install --optimize-autoloader --no-dev
```

### Step 5: Run Database Migrations
```bash
php artisan migrate --force
```

### Step 6: Seed Database (Optional)
```bash
php artisan db:seed
```

### Step 7: Set Permissions
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### Step 8: Create Storage Link
```bash
php artisan storage:link
```

### Step 9: Clear Cache
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🌐 Domain Configuration

### Option 1: Subdomain (Recommended)
- Create subdomain: `carrental.pznstudio.shop`
- Point to `public_html/car-rental-system/public`

### Option 2: Main Domain
- Move Laravel files to `public_html`
- Move contents of `public` folder to `public_html`
- Update `.env` APP_URL accordingly

## 📁 File Structure on Hostinger
```
public_html/
├── app/
├── bootstrap/
├── config/
├── database/
├── resources/
├── routes/
├── storage/
├── vendor/
├── .env
├── artisan
├── composer.json
└── public/
    ├── index.php
    ├── css/
    ├── js/
    └── storage/ (symlink)
```

## 🔐 Security Configuration

### 1. **Hide Sensitive Files**
Create `.htaccess` in root directory:
```apache
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
```

### 2. **Optimize Performance**
Add to `.htaccess`:
```apache
# Enable compression
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/plain
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/xml
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE application/xml
    AddOutputFilterByType DEFLATE application/xhtml+xml
    AddOutputFilterByType DEFLATE application/rss+xml
    AddOutputFilterByType DEFLATE application/javascript
    AddOutputFilterByType DEFLATE application/x-javascript
</IfModule>

# Browser caching
<IfModule mod_expires.c>
    ExpiresActive on
    ExpiresByType text/css "access plus 1 year"
    ExpiresByType application/javascript "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
</IfModule>
```

## 📧 Email Configuration

### For Hostinger SMTP:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=your-email@yourdomain.com
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@pznstudio.shop"
MAIL_FROM_NAME="Car Rental System"
```

## 🧪 Testing After Deployment

### 1. **Test Basic Functionality**
- Visit your domain
- Test car listings
- Test user registration
- Test login functionality

### 2. **Test Admin Panel**
- Login with: `admin@carrental.com` / `password`
- Test car management
- Test supplier management

### 3. **Test Supplier Panel**
- Login with: `john@supplier.com` / `password`
- Test car creation
- Test booking management

## 🚨 Troubleshooting

### Common Issues:

1. **500 Error**: Check file permissions and .env configuration
2. **Database Connection Error**: Verify database credentials
3. **Storage Link Error**: Run `php artisan storage:link`
4. **Permission Denied**: Set correct permissions on storage and cache folders

### Debug Mode (Temporary):
```env
APP_DEBUG=true
LOG_LEVEL=debug
```

## 📊 Performance Optimization

### 1. **Enable OPcache** (if available)
```ini
opcache.enable=1
opcache.memory_consumption=128
opcache.max_accelerated_files=4000
opcache.revalidate_freq=2
```

### 2. **Database Optimization**
- Add indexes for frequently queried columns
- Use database caching for static data

### 3. **Asset Optimization**
- Minify CSS and JavaScript
- Optimize images
- Use CDN for static assets

## 🔄 Updates and Maintenance

### Regular Tasks:
1. **Clear cache weekly**:
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   ```

2. **Monitor logs**:
   ```bash
   tail -f storage/logs/laravel.log
   ```

3. **Backup database regularly**

## 📞 Support

If you encounter any issues during deployment:
1. Check Hostinger error logs
2. Verify file permissions
3. Ensure all dependencies are installed
4. Check database connectivity

---

**🎉 Your Laravel Car Rental System is now ready for production deployment on Hostinger!**
