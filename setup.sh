docker-compose up -d --build

docker exec -ti petshopapi_app_1 composer install

docker exec -ti petshopapi_app_1 php artisan key:generate

docker-compose exec -ti petshopapi_app_1 php artisan config:cache
