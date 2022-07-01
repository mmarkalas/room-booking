#!/bin/sh

# BACKEND
cd ./backend
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
php artisan passport:install
php artisan db:seed

# BACKEND
cd ../frontend
npm install
npm run build

# DOCKER
cd ..
cp .docker-compose.yml.example .docker-compose.yml
docker-compose build --no-cache
docker-compose up -d
