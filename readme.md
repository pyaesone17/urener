## Installation

#### Install dependecy of the application
``` bash
composer install
```

#### Migrate the database for laravel passport and application tables
``` bash
php artisan migrate
```

#### Generate the client for password grant
``` bash
php artisan passport:client --password
```

#### Serve the application
``` bash
php artisan serve
```


## Command Line
#### Make the admin user via cli for api authentication
``` bash
php artisan make:admin
```

#### Add the urlshortener via cli easily
``` bash
php artisan urlshortener:make
```

#### List the available urlshorteners via cli 
``` bash
php artisan urlshortener:list {page(1,2,3,4)}
```

## Tests
``` bash
/vendor/bin/phpunit
```
