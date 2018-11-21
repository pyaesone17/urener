<?php 

namespace App\ValidationRules;

use Illuminate\Validation\Rule;

class UrlFormRule
{
    public static function rules($method, $id=null) : array
    {
        if ($method==="POST") {
            return [
                'redirect_url' => 'required|url',
                'slug' => 'unique:urls',
                'alias' => 'unique:urls',
            ];
        }

        return [
            'redirect_url' => 'required|url',
            'slug' => Rule::unique('urls')->ignore($id, 'id'),
            'alias' => Rule::unique('urls')->ignore($id, 'id'),
        ];
    }
}
