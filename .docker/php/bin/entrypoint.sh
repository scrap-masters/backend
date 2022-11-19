#!/usr/bin/env sh

php artisan migrate

php artisan optimize

set -e
php-fpm -D
nginx -g 'daemon off;'
