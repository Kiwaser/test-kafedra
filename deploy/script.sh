#!/bin/sh

docker compose exec php composer update

docker compose exec php composer install

docker compose exec php php artisan key:generate

docker compose exec php php artisan migrate:fresh --seed