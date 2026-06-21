#!/bin/bash
# ============================================================
# IFS LMS — Quick Update Script
# Run this on cPanel Terminal to pull latest code and update.
# Usage: bash update.sh [branch]
# ============================================================

set -e

CPANEL_USER=$(whoami)
APP_DIR="/home/$CPANEL_USER/lms"
PUBLIC_HTML="/home/$CPANEL_USER/public_html"
BRANCH="${1:-main}"

GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

info() { echo -e "${GREEN}[✔]${NC} $1"; }
warn() { echo -e "${YELLOW}[!]${NC} $1"; }

echo ""
echo "╔══════════════════════════════════════════════════════╗"
echo "║   IFS LMS — Update Script                           ║"
echo "╚══════════════════════════════════════════════════════╝"
echo ""

cd "$APP_DIR"

# Pull latest code
info "Pulling latest from branch: $BRANCH"
git fetch origin
git reset --hard origin/$BRANCH

# Dependencies
info "Updating Composer packages..."
composer install --no-dev --optimize-autoloader --no-interaction

# Migrations
info "Running migrations..."
php artisan migrate --force

# Cache
info "Rebuilding cache..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Permissions
chmod -R 775 storage bootstrap/cache

# Sync public assets (preserves your custom index.php)
info "Syncing public assets to public_html..."
rsync -a --delete public/ "$PUBLIC_HTML/" --exclude=index.php

echo ""
info "Update complete! Site is live at your domain."
echo ""
