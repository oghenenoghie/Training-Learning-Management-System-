# Deploying to cPanel

## Prerequisites

| Requirement | Version |
|---|---|
| PHP | 8.2+ |
| MySQL | 5.7+ |
| Composer | 2.x |
| Git | any |

---

## Step 1 — Set PHP Version

In cPanel → **MultiPHP Manager**, set your domain to **PHP 8.2** or higher.

---

## Step 2 — Create a MySQL Database

1. cPanel → **MySQL Databases**
2. Create database: e.g. `username_lms`
3. Create user and assign **ALL PRIVILEGES**
4. Note the DB name, user, and password

---

## Step 3 — Open cPanel Terminal

cPanel → **Terminal**

---

## Step 4 — Clone the Repository

```bash
cd ~
git clone https://github.com/oghenenoghie/Training-Learning-Management-System-.git lms
```

This clones the project into `~/lms` (outside `public_html`).

---

## Step 5 — Run the Deploy Script

```bash
cd ~/lms
bash deploy.sh
```

The script will:
- Install Composer dependencies
- Prompt you to edit `.env` with your DB credentials
- Generate the app key
- Ask whether to run migrations
- Cache config, routes, and views
- Fix storage permissions
- Copy `public/` assets into `public_html/` and rewrite `index.php`

---

## Step 6 — Edit `.env`

When the script pauses, fill in your database details:

```env
APP_NAME="IFS Training LMS"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=username_lms
DB_USERNAME=username_dbuser
DB_PASSWORD=your_password
```

---

## File Structure on Server

```
/home/username/
├── lms/              ← Full Laravel app (cloned repo)
│   ├── app/
│   ├── vendor/
│   ├── .env
│   └── ...
└── public_html/      ← Web root — public/ assets copied here
    ├── index.php     ← Rewritten to point to ~/lms
    ├── .htaccess
    └── ...
```

---

## Updating the App

When you push new code, SSH/Terminal into cPanel and run:

```bash
cd ~/lms
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Troubleshooting

| Issue | Fix |
|---|---|
| 500 error | Check `~/lms/storage/logs/laravel.log` |
| White screen | Set `APP_DEBUG=true` in `.env` temporarily |
| Permission denied | `chmod -R 775 ~/lms/storage ~/lms/bootstrap/cache` |
| Class not found | `composer dump-autoload` |
| Migrations fail | Confirm DB credentials in `.env` |
