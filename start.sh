#!/bin/sh
set -e

echo "=== AirwayConnect Starting ==="
echo "PORT: ${PORT}"
echo "APP_ENV: ${APP_ENV}"

echo "--- Running Migrations ---"
php artisan migrate --force

echo "--- Starting Server on 0.0.0.0:${PORT} ---"
exec php artisan serve --host=0.0.0.0 --port=${PORT}
