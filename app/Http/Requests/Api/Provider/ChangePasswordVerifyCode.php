<?php

namespace App\Http\Requests\Api\Provider;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;

class ChangePasswordVerifyCode extends FormRequest
{
    public function __construct(Request $request)
    {
        $request['phone']        = fixPhone($request['phone']);
        $request['country_code'] = fixPhone($request['country_code']);
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    #[ArrayShape(['country_code' => "string", 'phone' => "string", 'code' => "string", 'device_id' => "string", 'device_type' => "string", 'type' => "string"])] public function rules(): array
    {
        return [
            'country_code' => 'required|exists:users,country_code',
            'phone'        => 'numeric|digits_between:9,10|required|unique:providers,phone,' . auth()->id(),
            'code'         => 'required|max:10',
            'device_id'    => 'required|max:250',
            'device_type'  => 'in:ios,android,web',
            'type' => 'nullable'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['type' => 'password']);
    }
}
