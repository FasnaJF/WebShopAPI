docker exec -ti webshopapi_app_1 chmod -R 777 /var/www/storage

docker exec -ti webshopapi_app_1 composer install

docker exec -ti webshopapi_app_1 php artisan key:generate

docker exec -ti webshopapi_app_1 php artisan config:cache

docker exec -ti webshopapi_app_1 php artisan migrate

docker exec -ti webshopapi_app_1 php artisan import:data
