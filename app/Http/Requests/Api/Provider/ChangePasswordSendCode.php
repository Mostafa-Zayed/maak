<?php

namespace App\Http\Requests\Api\Provider;

use App\Http\Requests\Api\BaseApiRequest;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;

class ChangePasswordSendCode extends BaseApiRequest
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
    #[ArrayShape(['country_code' => "string", 'phone' => "string"])] public function rules(): array
    {
        return [
            'country_code' => 'required|exists:users,country_code',
            'phone'        => 'numeric|digits_between:9,10|required|unique:providers,phone,' . auth()->id(),
            'type' => 'nullable',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['type' => 'password']);
    }
}
