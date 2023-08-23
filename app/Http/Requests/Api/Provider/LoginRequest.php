<?php

namespace App\Http\Requests\Api\Provider;

use App\Http\Requests\Api\BaseApiRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;

class LoginRequest extends BaseApiRequest
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
    #[ArrayShape(['country_code' => "string", 'phone' => "string", 'password' => "string", 'device_id' => "string", 'device_type' => "string"])] public function rules(): array
    {
        return [
            'country_code' => 'required|numeric|digits_between:2,5',
            'phone'        => 'required|numeric|digits_between:9,10|exists:providers,phone,deleted_at,NULL',
            'password'     => 'required|min:6|max:100',
            'device_id'   => 'required|max:250',
            'device_type' => 'required|in:ios,android,web',
        ];
    }
}
