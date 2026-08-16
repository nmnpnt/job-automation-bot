<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Job Automation System

This is a Laravel-based system that uses Puppeteer and a Chrome Extension to automate applying for jobs across multiple platforms like LinkedIn, Naukri, Uplers, Unstop, Hirist, and Cutshort.

## Deployment (Docker)

The application includes a fully containerized setup for production using Docker and Docker Compose.

1. Ensure you have Docker and Docker Compose installed.
2. Clone the repository to your server.
3. Copy `.env.example` to `.env` and configure your database (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) and Discord Webhooks.
4. Run the stack:
   ```bash
   docker-compose up -d --build
   ```
5. Install dependencies and run migrations inside the container:
   ```bash
   docker-compose exec app composer install --optimize-autoloader --no-dev
   docker-compose exec app php artisan key:generate
   docker-compose exec app php artisan migrate --force
   ```
6. The application is now accessible on port `8000`. The background worker and scheduler are already running.

## Local Development

If you prefer to run it locally without Docker:
1. `composer install`
2. `npm install` inside the root and `/bot` folder.
3. `php artisan serve` and `npm run dev`
