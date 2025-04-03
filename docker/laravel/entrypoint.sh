#!/bin/bash
echo "Preparing Laravel..."
composer install
if [ -z "${APP_KEY}" ]; then
php artisan key:generate
fi
if [ -z "${JWT_SECRET}" ]; then
php artisan jwt:secret
fi
php artisan migrate --force --seed
echo "Laravel started"
exec php-fpm
