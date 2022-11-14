#!/usr/bin/env sh

php artisan migrate

set -e
php-fpm -D
nginx -g 'daemon off;'
