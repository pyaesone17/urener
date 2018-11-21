<?php 

namespace App\ValidationRules;

use Illuminate\Validation\Rule;
use App\Rules\DnsExist;
use Config;

class UrlFormRule
{
    public static function rules($method, $id=null) : array
    {
        $redirectUrlRule = ['required', 'url'];

        if (Config::get('urlshortener.dnscheck')) {
            $redirectUrlRule[]=new DnsExist;
        }

        if ($method==="POST") {
            return [
                'redirect_url' =>$redirectUrlRule,
                'slug' => 'unique:urls',
                'alias' => 'unique:urls',
            ];
        }

        return [
            'redirect_url' => $redirectUrlRule,
            'slug' => Rule::unique('urls')->ignore($id, 'id'),
            'alias' => Rule::unique('urls')->ignore($id, 'id'),
        ];
    }
}
