#!/usr/bin/env bash

docker-compose exec php php artisan migrate:fresh --env=testing --seed --quiet
docker-compose exec php phpunit $*
