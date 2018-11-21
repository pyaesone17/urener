## About Urener

URENER is a url shortener web application based on laravel. It mainly use Automatic Dependency Injection of Laravel service container to abstract the implementation from high level code. Thanks to Taylor Otwell for this awesome framework. This repository focus on the pricinple of "Code to interface" and SOLID. The features of the application include

* Custom slug on top of the Id generator
* Logging the visitor
* Laravel Passport Authentication
* Caching the url
* Unit Test & Integration Test & Behavior Test
* DNS checker validation
* Pluggable slug generator
* CLI powered administration

Urener is accessible, yet powerful and robust application to make shorten url.

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

#### 2. Create Admin User
``` bash
php artisan make:admin
```

#### 3. Issue Access Token

``` php
    $response = $http->post('http://your-app.com/oauth/token', [
        'form_params' => [
            'grant_type' => 'password',
            'client_id' => 'client-id',
            'client_secret' => 'client-secret',
            'username' => 'admin@shortener.com',
            'password' => 'my-password',
            'scope' => '',
        ],
    ]);
```

#### 4. Create url shortener
POST /admin/urls
```json
{
    "alias" : "hcm",
    "redirect_url" : "https://hinchatmal.com/",
}
```

#### 5. Visit the alias url, boom you are redirected to the destination
http://127.0.0.1:8000/hcm


## Available Endpoints

#### 1. View url shortener list
GET /admin/urls/1

#### 2. View url shortener detail
GET /admin/urls/1

#### 3. Create url shortener
POST /admin/urls
```json
{
    "alias" : "hcm",
    "redirect_url" : "https://hinchatmal.com/",
}
```

#### 4.Update url shortener
PUT /admin/urls/1
```json
{
    "alias" : "hcm",
    "redirect_url" : "https://hinchatmal.com/",
}
```

#### 5. Delete url shortener
DELETE /admin/urls/1

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

## Configuration

#### ID Generator Driver
Currently the app supports two style for generating random slug
"youtube" style short id generator and "uuid" generator, configure it on .env.

ID_GENERATOR="youtube"

#### DNS rule validation
By default the application will validate whether provided redirect url is existed on realword or not.
To disable that feature, simply set false on .env. (Please not that DNS checking is disabled by default in Testing environment)

DNS_CHECK=false

## Testing
``` bash
/vendor/bin/phpunit
```
