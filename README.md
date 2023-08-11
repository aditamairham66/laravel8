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
You can replace ``{tableName}`` with the table name from your database example:
```php
php artisan create:model md_dosen
```

### Create auto service structured
with command base laravel
```php
php artisan create:service {tableName}
```
You can replace ``{tableName}`` with the table name from your database example:
```php
php artisan create:service md_dosen
```

### Create auto controller structured
this is like creating a controller using command from laravel but there is a little difference,
i.e. you are required to blind a table first.
then, you can enter the name of the table in the controller path that will be created for example:
```php
{pathController}\{nameTable}
```
for ```{nameTable}``` above, you can replace it with the name of your table by writing the Pascal case, for example:
```
table: md_dosen

//  become

table MdDosen
```

let's try create a controller with command base laravel.
```php
php artisan create:controller {name} {type} --withTable=no
```

You can replace ``{name}`` with the table name controller path like example below:

```php
php artisan create:controller Admin\MdDosen admin
```

You can replace ``{type}`` with two types namely ``general``, ``api``, and ``admin``. but by default use type ``general`` to output:
- ``general`` to generate controllers from being used in the backend or other example:
```php
php artisan create:controller Frontend\MdDosen general
```

- ``api`` to generate controllers for use in the api development example:
```php
php artisan create:controller Api\MdDosen api
```

- ``admin`` to generate controllers for use in the backend example:
```php
php artisan create:controller Admin\MdDosen admin
```

You can enter ``{--withTable}`` with ``yes``, and ``no``. but by default it is ``no``.

after creating controller you can register controller in laravel routes in ``routes/admin.php`` file
```injectablephp
    routeController('/{route_name}', '{PATH_TO_CONTROLLER}');
```

in a controller with type ``admin`` you can use some of the functions/methods that are already in the BaseController Class with
```injectablephp
    public function postActionSelected(Request $request)
    {
        // your logic code here
        
        return parent::postActionSelected($request)
    }
```
