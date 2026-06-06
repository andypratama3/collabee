# Production Deploy Guide

This document describes a production-ready deployment for the Collabee Laravel application tailored for a server with MySQL and Redis. The steps are written so an automated agent (opencode) can follow them.

Prerequisites (server):
- Ubuntu 22.04+ or similar
- PHP 8.3 with required extensions: pdo_mysql, redis, mbstring, openssl, curl, fileinfo, gd, xml
- Composer
- Node.js 20+ and npm or pnpm
- MySQL 8+
- Redis
- Supervisor (or systemd) for process management
- nginx or Apache (nginx recommended)

1) Create system user and directories

 - Create deploy user and project directory (example):
   - user: webapp
   - app path: /var/www/collabee

   sudo adduser --system --group --no-create-home webapp
   sudo mkdir -p /var/www/collabee
   sudo chown webapp:webapp /var/www/collabee

2) Install prerequisites

Follow platform-specific instructions. Example Ubuntu commands (run as root or with sudo):

 apt update && apt install -y php8.3 php8.3-fpm php8.3-mysql php8.3-redis php8.3-mbstring php8.3-xml php8.3-curl php8.3-gd unzip git nginx redis-server mysql-server supervisor
 curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
 npm ci (or pnpm install)

3) Database (MySQL)

 - Create database and user:
   sudo mysql -u root
   CREATE DATABASE collabee CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   CREATE USER 'collabee'@'127.0.0.1' IDENTIFIED BY 'strong_password_here';
   GRANT ALL PRIVILEGES ON collabee.* TO 'collabee'@'127.0.0.1';
   FLUSH PRIVILEGES;

 - Ensure MySQL is listening on 127.0.0.1 (bind-address) or on the private network if needed.

4) Clone repository and install app dependencies

 sudo -u webapp -H bash -lc "git clone https://your.git.repo.git /var/www/collabee || (cd /var/www/collabee && git pull)"
 cd /var/www/collabee
 sudo -u webapp -H bash -lc "composer install --no-dev --optimize-autoloader"
 sudo -u webapp -H bash -lc "npm ci && npm run build"

5) Environment configuration

 - Copy .env.example to .env and edit production values
   cp .env.example .env
   php artisan key:generate

 Required production env var highlights (set accordingly):
 - APP_ENV=production
 - APP_DEBUG=false
 - APP_URL=https://your.domain.com
 - DB_CONNECTION=mysql
 - DB_HOST=127.0.0.1
 - DB_PORT=3306
 - DB_DATABASE=collabee
 - DB_USERNAME=collabee
 - DB_PASSWORD=strong_password_here
 - QUEUE_CONNECTION=redis
 - CACHE_STORE=redis
 - REDIS_HOST=127.0.0.1
 - MAIL_MAILER=smtp (or mailgun)
 - MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD
 - FILESYSTEM_DISK=s3 (if using S3) and AWS_* variables
 - XENDIT_API_KEY and XENDIT_WEBHOOK_TOKEN (for payments)
 - REVERB_APP_ID/KEY/SECRET and REVERB_HOST/PORT if using Reverb

6) Storage and filesystem

 - Link storage: php artisan storage:link
 - If using S3, configure AWS_* env vars and set FILESYSTEM_DISK=s3

7) Run migrations and seeders

 sudo -u webapp -H bash -lc "php artisan migrate --force"
 sudo -u webapp -H bash -lc "php artisan db:seed --force"  # if you have seeders to run

8) Caching

 sudo -u webapp -H bash -lc "php artisan config:cache && php artisan route:cache && php artisan view:cache"

9) Supervisor & Horizon

 - Use provided example at docs/supervisor/horizon.conf. Place it at /etc/supervisor/conf.d/collabee-horizon.conf
 - Reload supervisor: sudo supervisorctl reread && sudo supervisorctl update && sudo supervisorctl start collabee-horizon:* (or start horizon)
 - Ensure QUEUE_CONNECTION=redis in .env

10) Reverb (WebSocket) process

 - Use docs/supervisor/reverb.conf to run the laravel reverb server. Ensure REVERB_* variables are set in .env

11) Cron (Scheduler)

 - Add to crontab for webapp user: * * * * * cd /var/www/collabee && php artisan schedule:run >> /dev/null 2>&1

12) Nginx configuration

 - Configure your nginx site to serve the app and point document root to /var/www/collabee/public

13) Post-deploy checks

 - redis-cli PING -> PONG
 - php artisan horizon:status
 - Check that broadcasting works by testing a private channel (login then trigger an event)
 - Xendit webhook test using their dashboard

14) Create missing Jobs (developer step)

 The repository currently references Jobs that may be missing. Create these as queued Jobs so long-running tasks run asynchronously. Examples:
 - SendWelcomeEmail
 - ProcessEscrow
 - ReleaseEscrow
 - GenInvoicePDF
 - GenContractPDF
 - SendCampaignRem
 - BackupDB

15) Monitoring & backups

 - Configure log rotation
 - Install Horizon monitoring and secure the dashboard
 - Add regular database backups (cron job or spatie/laravel-backup)

Appendix: Useful Commands

 - php artisan queue:work --tries=3
 - php artisan horizon
 - sudo supervisorctl status
