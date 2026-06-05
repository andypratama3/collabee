# Collabee Deployment Guide

## Production Checklist

- [ ] Set APP_ENV=production, APP_DEBUG=false in .env
- [ ] Generate APP_KEY: `php artisan key:generate`
- [ ] Cache config: `php artisan config:cache`
- [ ] Cache routes: `php artisan route:cache`
- [ ] Cache views: `php artisan view:cache`
- [ ] Optimize: `php artisan optimize`
- [ ] Storage link: `php artisan storage:link`
- [ ] Set up MySQL/PostgreSQL database
- [ ] Run migrations: `php artisan migrate --force`
- [ ] Set up cron for scheduler
- [ ] Set up supervisor for queue/Horizon + Reverb

## Prerequisites

- PHP 8.3+
- Composer 2.x
- Node.js 20+
- Redis (for queues, cache, broadcasting)
- MySQL 8+ or PostgreSQL 15+
- Supervisor (for Horizon & Reverb)

## Environment Variables

Copy `.env.example` to `.env` and configure:

### App Configuration
```
APP_NAME=Collabee
APP_ENV=production
APP_DEBUG=false
APP_URL=https://collabee.com
```

### Database
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=collabee
DB_USERNAME=forge
DB_PASSWORD=
```

### Redis
```
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### Mail (Mailgun)
```
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=
MAILGUN_SECRET=
MAIL_FROM_ADDRESS=noreply@collabee.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Reverb (WebSocket)
```
REVERB_APP_ID=
REVERB_APP_KEY=
REVERB_APP_SECRET=
REVERB_HOST=collabee.com
REVERB_PORT=443
REVERB_SCHEME=https
VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_HOST}"
VITE_REVERB_PORT="${REVERB_PORT}"
```

### Xendit (Payment Gateway)
```
XENDIT_API_KEY=
XENDIT_WEBHOOK_TOKEN=
```

### Scout (Search)
```
SCOUT_DRIVER=database
```

### AWS S3 (Media Storage)
```
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=ap-southeast-1
AWS_BUCKET=collabee-media
AWS_USE_PATH_STYLE_ENDPOINT=false
```

## SSL/TLS (Let's Encrypt)

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d collabee.com -d www.collabee.com
```

Auto-renewal is configured automatically by certbot. Test with:
```bash
sudo certbot renew --dry-run
```

## S3 Storage Setup

1. Create S3 bucket in AWS Console (e.g. `collabee-media`)
2. Block public access (use CloudFront or pre-signed URLs)
3. Create IAM user with programmatic access
4. Attach policy allowing read/write to the bucket:

```json
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Effect": "Allow",
            "Action": [
                "s3:PutObject",
                "s3:GetObject",
                "s3:DeleteObject",
                "s3:ListBucket"
            ],
            "Resource": [
                "arn:aws:s3:::collabee-media",
                "arn:aws:s3:::collabee-media/*"
            ]
        }
    ]
}
```

5. Set env variables: `AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY`, `AWS_DEFAULT_REGION`, `AWS_BUCKET`
6. Update `config/filesystems.php` to use S3 as default disk
7. Configure Spatie MediaLibrary to use S3 in `config/media-library.php`

## Cron (Scheduler)

Add to crontab (`crontab -e`):
```
* * * * * cd /var/www/collabee && php artisan schedule:run >> /dev/null 2>&1
```

## Queue (Horizon)

See `docs/supervisor/horizon.conf` for Supervisor configuration.

## WebSocket (Reverb)

See `docs/supervisor/reverb.conf` for Supervisor configuration.

## Deployment Steps

```bash
cd /var/www/collabee

git pull origin main

composer install --no-dev --optimize-autoloader

php artisan migrate --force

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

npm ci && npm run build

sudo supervisorctl restart all
```

## Monitoring

- Horizon: `https://collabee.com/horizon`
- Logs: `storage/logs/laravel.log`
- Reverb: Check status via `php artisan reverb:status`
- PHP-FPM: Check with `php artisan about`
