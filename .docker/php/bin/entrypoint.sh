#!/usr/bin/env sh

php artisan migrate

php artisan cache:clear

php artisan optimize

set -e
supervisord --nodaemon --configuration /etc/supervisor/conf.d/supervisord.conf
