<?php

namespace App\Http\Requests\Admin\services;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name.ar'                  => 'required|max:191',
            'name.en'  => 'required|max:191',
            'slug' => 'nullable',
            'status' => 'nullable',
            'category_id' => 'required|exists:categories,id'
        ];
    }
}
