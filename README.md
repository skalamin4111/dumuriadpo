# DPO ERP

DPO ERP is a Laravel 12 MVP for a cloud-based service operations ERP/CRM platform. It includes role-based authentication, employees, customers, task management, overdue escalation, daily reports, notifications, dashboards, REST APIs, queues, and Docker support.

## Setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build
php artisan serve
```

Demo login:

- `admin@dpoerp.test`
- `password`

## Docker

```bash
docker compose up --build
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
```

Open `http://localhost:8000`.

## Architecture

- `app/Services` contains business workflows.
- `app/Repositories` contains data access contracts and Eloquent implementations.
- `app/Http/Requests` validates form and API input.
- `app/Http/Resources` shapes API responses.
- `app/Policies` enforces permissions through Spatie roles.
- `routes/api.php` exposes Sanctum-protected REST APIs.
- `routes/console.php` schedules overdue task processing.
