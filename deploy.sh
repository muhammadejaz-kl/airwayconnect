#!/bin/bash
# ============================================================
# AirwayConnect - EC2 Deployment Script
# Run this script ON the EC2 server after SSH connection
# Usage: bash deploy.sh
# ============================================================

set -e

APP_DIR="/var/www/airwayconnect"
GIT_REPO="https://github.com/YOUR_USERNAME/YOUR_REPO.git"   # <-- apna GitHub repo URL yahan daalein
GIT_BRANCH="main"                                             # <-- apni branch ka naam (main ya master)

echo "========================================="
echo "  AirwayConnect EC2 Deployment Started"
echo "========================================="

# ---- 1. Check if this is first deployment or update ----
if [ -d "$APP_DIR/.git" ]; then
    echo ""
    echo ">>> [UPDATE] Existing project found. Pulling latest code..."
    cd "$APP_DIR"
    git fetch origin
    git reset --hard origin/$GIT_BRANCH
    git pull origin $GIT_BRANCH
else
    echo ""
    echo ">>> [FRESH] Cloning project for the first time..."
    sudo mkdir -p "$APP_DIR"
    sudo chown -R $USER:$USER "$APP_DIR"
    git clone -b $GIT_BRANCH "$GIT_REPO" "$APP_DIR"
    cd "$APP_DIR"
fi

cd "$APP_DIR"

# ---- 2. Copy .env file (only on fresh deployment) ----
if [ ! -f ".env" ]; then
    echo ""
    echo ">>> .env file nahi mili. .env.example se copy kar raha hoon..."
    cp .env.example .env
    echo "!!! IMPORTANT: .env file mein apni database aur app settings daalein !!!"
    echo "    Baad mein: nano .env"
fi

# ---- 3. Install PHP dependencies ----
echo ""
echo ">>> Composer packages install ho rahi hain..."
composer install --no-dev --optimize-autoloader --no-interaction

# ---- 4. Install Node dependencies and build assets ----
echo ""
echo ">>> NPM packages install aur assets build ho rahi hain..."
npm install
npm run build
rm -rf node_modules   # disk space bachane ke liye

# ---- 5. Laravel setup commands ----
echo ""
echo ">>> Laravel setup commands chal rahi hain..."

# Generate app key (sirf fresh deployment par)
if grep -q "APP_KEY=$" .env 2>/dev/null || grep -q "APP_KEY=\"\"" .env 2>/dev/null; then
    php artisan key:generate
fi

php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# ---- 6. Run database migrations ----
echo ""
echo ">>> Database migrations chal rahi hain..."
php artisan migrate --force

# ---- 7. Storage symlink ----
echo ""
echo ">>> Storage symlink bana raha hoon..."
php artisan storage:link --force

# ---- 8. Optimize for production ----
echo ""
echo ">>> Production optimization..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# ---- 9. Set correct permissions ----
echo ""
echo ">>> Permissions set kar raha hoon..."
sudo chown -R www-data:www-data "$APP_DIR"
sudo chmod -R 755 "$APP_DIR"
sudo chmod -R 775 "$APP_DIR/storage"
sudo chmod -R 775 "$APP_DIR/bootstrap/cache"

# ---- 10. Restart web server ----
echo ""
echo ">>> Web server restart ho raha hai..."
# Nginx ke liye:
if command -v nginx &> /dev/null; then
    sudo systemctl reload nginx
    echo "    Nginx reloaded."
fi

# Apache ke liye:
if command -v apache2 &> /dev/null; then
    sudo systemctl reload apache2
    echo "    Apache reloaded."
fi

# PHP-FPM ke liye:
if command -v php-fpm8.2 &> /dev/null; then
    sudo systemctl reload php8.2-fpm
    echo "    PHP-FPM reloaded."
elif systemctl list-units --type=service | grep -q "php.*fpm"; then
    sudo systemctl reload $(systemctl list-units --type=service | grep "php.*fpm" | awk '{print $1}')
    echo "    PHP-FPM reloaded."
fi

echo ""
echo "========================================="
echo "  Deployment Complete!"
echo "========================================="
echo ""
echo "  App URL: http://$(curl -s http://169.254.169.254/latest/meta-data/public-ipv4 2>/dev/null || echo 'YOUR_EC2_IP')"
echo ""
