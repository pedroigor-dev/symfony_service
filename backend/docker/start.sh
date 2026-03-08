#!/bin/sh
set -e

echo "Running database migrations..."
php bin/console doctrine:migrations:migrate --no-interaction

echo "Starting supervisord..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
