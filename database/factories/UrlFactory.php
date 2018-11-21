<?php

use Faker\Generator as Faker;

$factory->define(App\Url::class, function (Faker $faker) {
    return [
        'redirect_url' => "https://www.google.com",
        'slug' => str_random(10),
        'alias' => str_random(10),
    ];
});
