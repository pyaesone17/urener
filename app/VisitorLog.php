<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug', 'redirect_url', 'ip_address', 'client'
    ];
}
