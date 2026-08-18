#!/bin/sh
set -e

# Wait for database (optional, wait-for-it pattern can be used)

echo "Running migrations..."
php artisan migrate --force

echo "Starting PHP-FPM..."
exec "$@"
