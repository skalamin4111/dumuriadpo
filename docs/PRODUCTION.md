# Production Runbook

## Required Services

- PHP 8.3+
- MySQL 8.0+ or PostgreSQL-compatible future adapter
- Redis for cache, queue, and realtime scaling
- Nginx
- Supervisor
- S3-compatible object storage for production files

## Recommended Commands

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
php artisan queue:restart
```

## Workers

Use the Supervisor configs in `config/supervisor`.

## SaaS

Company isolation is represented by `companies` and nullable `company_id` columns. New records inherit the authenticated user's company through middleware and service-layer assignment. Billing is intentionally not implemented yet.
