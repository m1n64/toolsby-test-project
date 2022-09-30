*****

### How to startup (if your php >= 7.4):
1. composer install
2. npm install
3. create database
    1. create DB in mysql
4. copy .env.example to .env and config DB_\* connection
5. php artisan key:generate
5. php artisan migrate --seed
6. php artisan serve
7. npm run dev (opt)

### How to startup (via docker):
1. docker-compose build app
2. docker-compose exec app composer install
3. docker-compose exec app npm install
4. copy .env.example to .env and config DB_\* connection
5. docker-compose exec app php artisan key:generate
6. docker-compose exec app artisan migrate --seed
7. docker-compose exec app up (or with -d)
8. docker-compose exec app npm run dev (opt)

or use DockStation or another Docker GUI app.
