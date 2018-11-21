<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Idgenerator Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default Idgenerator "driver" that will be used on 
    | generating auto slug of url shortener. By default, we will use the youtube driver 
    | but you may specify any of the other wonderful drivers provided here.
    |
    | Supported: "youtube", "uuid"
    |
    */

    'idgenerator' => env('ID_GENERATOR', 'youtube'),
];
