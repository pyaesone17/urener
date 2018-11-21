## Installation

#### Install dependecy of the application
``` bash
composer install
```

#### Migrate the database for laravel passport and application tables
``` bash
php artisan migrate
```


#### Install laravel passport
``` bash
php artisan passport:install
```

#### Serve the application
``` bash
php artisan serve
```

## Application Flow

#### 1. Generate the client for password grant
``` bash
php artisan passport:client --password
```

#### 2. Issue Access Token

``` php
    $response = $http->post('http://your-app.com/oauth/token', [
        'form_params' => [
            'grant_type' => 'password',
            'client_id' => 'client-id',
            'client_secret' => 'client-secret',
            'username' => 'taylor@laravel.com',
            'password' => 'my-password',
            'scope' => '',
        ],
    ]);
```

#### 3. Create url shortener
POST /admin/urls
```json
{
    "alias" : "hcm",
    "redirect_url" : "https://hinchatmal.com/",
}
```

#### 4. Visit the alias url, boom you are redirected to the destination
http://127.0.0.1/hcm


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
