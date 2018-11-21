<?php 

namespace App\ValidationRules;

use Illuminate\Validation\Rule;

class AdminFormRule
{
    public static function rules($method, $id=null) : array
    {
        if ($method==="POST") {
            return [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required'
            ];
        }

        return [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id, 'id')
            ]
        ];
    }
}
