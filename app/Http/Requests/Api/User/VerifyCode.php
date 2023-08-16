<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Api\BaseApiRequest;
use Illuminate\Http\Request;

class VerifyCode extends BaseApiRequest
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
    public function rules(): array
    {
        return [
            'code'         => 'required|min:3|max:10',
            'country_code' => 'required|exists:users,country_code',
            'phone'        => 'required|exists:users,phone',
            'device_id'    => 'required|max:250',
            'device_type'  => 'in:ios,android,web',
        ];
    }
}
