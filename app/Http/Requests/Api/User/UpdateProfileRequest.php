<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Api\BaseApiRequest;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;

class UpdateProfileRequest extends BaseApiRequest
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
    #[ArrayShape(['name' => "string[]", 'email' => "string[]", 'country_code' => "string", 'phone' => "string", 'device_id' => "string", 'device_type' => "string"])] public function rules(): array
    {
        return [
            'name' => ['required','min:3','max:100'],
            'email' => ['required','email'],
            'country_code' => 'required|exists:users,country_code',
            'phone'        => 'required|exists:users,phone',
            'device_id'   => 'required|max:250',
            'device_type' => 'required|in:ios,android,web',
        ];
    }
}
