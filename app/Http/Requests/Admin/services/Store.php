<?php

namespace App\Http\Requests\Admin\services;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class Store extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name.ar'                  => 'required|max:191',
            'name.en'  => 'required|max:191',
            'slug' => 'nullable',
            'status' => 'nullable|in:0,1',
            'category_id' => 'required|exists:categories,id'
        ];
    }

    public  function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug($this->name['en'])
        ]);
    }
}
