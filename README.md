# Installation
You can install with conditions:
- PHP >= 7.4
- MYSQL >= 5.7
- POSTGRE >= 10, 11, 12
- SERVER OS With Nginx/Apache/XAMPP/Laragon

## First Step
- run below command to install all laravel packages
```php
composer install
```

- change all configuration in .env file to connect database
- You can try base by running locale with
```http request
http://localhost/{{your_app}}/public/admin
```

## Second Step
- after all the first steps go you can try to install tables and data
```php
php artisan migrate
```
```php
php artisan db:seed --class=CMSUserSeeder
```
- Don't forget to run symlinks if you need to upload one or more files in Laravel
```php
php artisan storage:link
```

### Create auto model structured
with command base laravel
```php
php artisan create:model {tableName}
```
You can replace ``{tableName}`` with the table name from your database

### Create auto service structured
with command base laravel
```php
php artisan create:service {tableName}
```
You can replace ``{tableName}`` with the table name from your database

### Create auto controller structured
with command base laravel
```php
php artisan create:controller {name} {type}
```
You can replace ``{name}`` with the table name from your database
You can replace ``{type}`` with two types namely ``general``, ``api``, and ``admin``. but by default use type ``general`` to output:
- ``general`` to generate controllers from being used in the backend
- ``api`` to generate controllers for use in the api development
- ``admin`` to generate controllers for use in the backend

after creating controller you can register controller in laravel routes in ``routes/admin.php`` file
```injectablephp
    routeController('/{route_name}', '{PATH_TO_CONTROLLER}');
```
