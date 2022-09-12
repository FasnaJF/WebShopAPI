docker exec -ti webshopapi_app_1 php artisan cache:clear

docker exec -ti webshopapi_app_1 php artisan migrate --env=testing

docker exec -ti webshopapi_app_1 php artisan test

