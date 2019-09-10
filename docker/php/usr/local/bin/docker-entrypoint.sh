#!/bin/bash
set -e

# DB connection settings
DB_HOST=${MYSQL_HOST:-mysql}
DB_PORT=${MYSQL_PORT:-3306}
DB_TIMEOUT=${MYSQL_TIMEOUT:-240}

# Redis connection settings
REDIS_HOST=${REDIS_HOST:-redis}
REDIS_PORT=${REDIS_PORT:-6379}
REDIS_TIMEOUT=${REDIS_TIMEOUT:-30}

COMMAND="${@:-0}"

# First arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	php "$@"

# Run queue
elif [ "$COMMAND" == "worker" ]; then
    echo "Waiting for Redis …"
    wait-for "$REDIS_HOST":"$REDIS_PORT" --timeout="$REDIS_TIMEOUT"

    echo "Waiting for DB …"
    wait-for "$DB_HOST":"$DB_PORT" --timeout="$DB_TIMEOUT"

    echo "Running worker …"
    exec su -c "php /var/www/artisan queue:work --verbose --tries=3 --timeout=90" -s /bin/sh www-data

# Run scheduler
elif [ "$COMMAND" == "scheduler" ]; then
    echo "Waiting for Redis …"
    wait-for "$REDIS_HOST":"$REDIS_PORT" --timeout="$REDIS_TIMEOUT"

    echo "Waiting for DB …"
    wait-for "$DB_HOST":"$DB_PORT" --timeout="$DB_TIMEOUT"

    while [ true ]
    do
      echo "Running scheduler …"
      su -c "php /var/www/artisan schedule:run" -s /bin/sh www-data
      sleep 60
    done

# Run php-fpm
else
    if [ ! -f "/var/www/.env" ]; then
        echo "Copying .env.example file …"
        su www-data -s /bin/sh -c "cp /var/www/.env.example /var/www/.env"
    fi

    if [ "$PHP_RUN_COMPOSER_INSTALL" ]; then
        echo "Installing dependencies …"
        # Run as root to avoid permission problems
        composer install
        chown -R www-data:www-data /var/www/vendor
    fi

    echo "Setting permissions of /var/www/storage/ …"
    chown -R www-data:www-data /var/www/storage/

    APP_KEY=$(grep -m 1 "APP_KEY=" .env | sed -e 's/APP_KEY=//g')
    if [ -z "$APP_KEY" ]; then
        echo "Generating Laravel app key …"
        php artisan key:generate
    fi

    echo "Waiting for Redis …"
    wait-for "$REDIS_HOST":"$REDIS_PORT" --timeout="$REDIS_TIMEOUT"

    echo "Waiting for DB …"
    wait-for "$DB_HOST":"$DB_PORT" --timeout="$DB_TIMEOUT"
    
    echo "Running migrations …"
    php artisan migrate --force

    echo "Clearing cache …"
    su -c "php /var/www/artisan cache:clear" -s /bin/sh www-data

    # echo "Optimizing config and route loading …"
    # su -c "php /var/www/artisan config:cache" -s /bin/sh www-data
    # su -c "php /var/www/artisan route:cache" -s /bin/sh www-data

    exec "$@"
fi
