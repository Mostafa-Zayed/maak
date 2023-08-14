<?php

namespace App\Http\Requests\Admin\features;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name.en'                  => 'required|max:191',
            'name.ar'                  => 'required|max:191',
            'status' => 'nullable|in:0,1'
        ];
    }
}
