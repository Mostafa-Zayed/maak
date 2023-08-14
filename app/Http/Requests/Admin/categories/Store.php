<?php

namespace App\Http\Requests\Admin\categories;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class store extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name.ar'                  => 'required|max:191',
            'name.en'                  => 'required|max:191',
            'parent_id'                => 'required|nullable|exists:categories,id',
            'image'                    => ['nullable','image'],
            'slug' => ['nullable']
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug($this->name['ar'])
        ]);
    }
}
