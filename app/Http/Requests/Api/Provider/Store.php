<?php

namespace App\Http\Requests\Api\Provider;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{

    public function rules(): array
    {
        return [
            'image'  =>  'required|image|mimes:jpg,png',
            'name'   => 'required|max:100',
            'phone'  => 'required|digits_between:9,11',
            'city'   => 'required|max:100',
            ''
        ];
    }
}
