## Installation

#### install dependecy of the application
composer install

#### migrate the database for laravel passport and application tables
php artisan migrate

#### generate the client for password grant
php artisan passport:client --password

#### serve the application
php artisan serve


## Command Line
#### make the admin user via cli for api authentication
php artisan make:admin

#### add the urlshortener via cli easily
php artisan urlshortener:make

#### list the available urlshorteners via cli 
php artisan urlshortener:list {page(1,2,3,4)}

## Tests
/vendor/bin/phpunit