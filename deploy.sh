#!/bin/bash
# ============================================================
# IFS LMS — cPanel Deployment Script
# Run this once inside cPanel Terminal after cloning the repo.
#
# Usage:
#   bash deploy.sh
#
# What it does:
#   1. Installs Composer dependencies
#   2. Creates .env from .env.example
#   3. Generates app key
#   4. Runs migrations
#   5. Caches config/routes/views
#   6. Fixes storage permissions
#   7. Symlinks public/ into public_html
# ============================================================

set -e

# ── CONFIG — edit these ─────────────────────────────────────
CPANEL_USER=$(whoami)
APP_DIR="/home/$CPANEL_USER/lms"          # Where you cloned the repo
PUBLIC_HTML="/home/$CPANEL_USER/public_html"  # cPanel web root
# ────────────────────────────────────────────────────────────

GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m'

info()    { echo -e "${GREEN}[✔]${NC} $1"; }
warn()    { echo -e "${YELLOW}[!]${NC} $1"; }
error()   { echo -e "${RED}[✘]${NC} $1"; exit 1; }

echo ""
echo "╔══════════════════════════════════════════════════════╗"
echo "║   IFS Nigeria LMS — cPanel Deploy Script            ║"
echo "╚══════════════════════════════════════════════════════╝"
echo ""

# ── Confirm we are in the right directory ───────────────────
if [ ! -f "$APP_DIR/artisan" ]; then
  error "Laravel artisan not found at $APP_DIR. Make sure you cloned the repo to ~/lms"
fi

cd "$APP_DIR"
info "Working directory: $APP_DIR"

# ── PHP version check ───────────────────────────────────────
PHP_VERSION=$(php -r "echo PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION;")
info "PHP version: $PHP_VERSION"
if (( $(echo "$PHP_VERSION < 8.2" | bc -l) )); then
  warn "Laravel 12 requires PHP 8.2+. Current: $PHP_VERSION"
  warn "Go to cPanel → MultiPHP Manager and switch to PHP 8.2 or higher."
  error "Aborting. Fix PHP version first."
fi

# ── Composer install ────────────────────────────────────────
info "Installing Composer dependencies (no dev)..."
composer install --no-dev --optimize-autoloader --no-interaction

# ── .env setup ──────────────────────────────────────────────
if [ ! -f ".env" ]; then
  cp .env.example .env
  info "Created .env from .env.example"
  warn "IMPORTANT: Edit .env now and set your DB credentials before continuing."
  echo ""
  echo "  nano $APP_DIR/.env"
  echo ""
  read -rp "Press ENTER after you have edited .env to continue..." _
else
  info ".env already exists, skipping copy."
fi

# ── App key ─────────────────────────────────────────────────
APP_KEY=$(grep "^APP_KEY=" .env | cut -d '=' -f2)
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
  php artisan key:generate
  info "App key generated."
else
  info "App key already set."
fi

# ── Database migration ──────────────────────────────────────
echo ""
read -rp "Run database migrations? (y/n): " RUN_MIGRATE
if [[ "$RUN_MIGRATE" =~ ^[Yy]$ ]]; then
  php artisan migrate --force
  info "Migrations complete."
else
  warn "Skipping migrations. Run manually: php artisan migrate --force"
fi

# ── Cache ───────────────────────────────────────────────────
info "Caching config, routes, and views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# ── Storage permissions ─────────────────────────────────────
info "Setting storage permissions..."
chmod -R 775 storage bootstrap/cache
info "Permissions set."

# ── Storage symlink ─────────────────────────────────────────
info "Creating storage symlink..."
php artisan storage:link 2>/dev/null || warn "Storage link already exists or failed — check manually."

# ── public_html setup ───────────────────────────────────────
echo ""
echo "Setting up public_html to serve the Laravel app..."

# Backup existing public_html index if it exists
if [ -f "$PUBLIC_HTML/index.php" ]; then
  mv "$PUBLIC_HTML/index.php" "$PUBLIC_HTML/index.php.bak"
  warn "Backed up existing index.php → index.php.bak"
fi

# Copy public assets into public_html
cp -r "$APP_DIR/public/." "$PUBLIC_HTML/"
info "Copied public/ assets to public_html/"

# Rewrite index.php paths to point to the app directory
cat > "$PUBLIC_HTML/index.php" <<PHP
<?php

define('LARAVEL_START', microtime(true));

// Maintenance mode check
if (file_exists(\$maintenanceFile = __DIR__.'/../lms/storage/framework/maintenance.php')) {
    require \$maintenanceFile;
}

require __DIR__.'/../lms/vendor/autoload.php';

\$app = require_once __DIR__.'/../lms/bootstrap/app.php';

\$kernel = \$app->make(Illuminate\Contracts\Http\Kernel::class);

\$response = \$kernel->handle(
    \$request = Illuminate\Http\Request::capture()
)->send();

\$kernel->terminate(\$request, \$response);
PHP

info "Updated public_html/index.php with correct paths."

# ── Final summary ───────────────────────────────────────────
echo ""
echo "╔══════════════════════════════════════════════════════╗"
echo "║   Deployment Complete!                              ║"
echo "╚══════════════════════════════════════════════════════╝"
echo ""
info "App directory : $APP_DIR"
info "Web root      : $PUBLIC_HTML"
echo ""
echo "  Next steps:"
echo "  1. Visit your domain to confirm the app is live."
echo "  2. Check logs at: $APP_DIR/storage/logs/laravel.log"
echo "  3. Set APP_DEBUG=false in .env when going live."
echo ""
