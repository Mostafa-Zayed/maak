<?php

namespace App\Http\Requests\Api\Provider;

use App\Http\Requests\Api\BaseApiRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use JetBrains\PhpStorm\ArrayShape;

class UpdatePasswordRequest extends BaseApiRequest
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
    #[ArrayShape(['country_code' => "string", 'phone' => "string", 'device_id' => "string", 'device_type' => "string", 'old_password' => "string", 'password' => "string", 'password_confirmation' => "string"])] public function rules(): array
    {
        return [
            'country_code' => 'required|exists:users,country_code',
            'phone'        => 'numeric|digits_between:9,10|required|unique:providers,phone,' . auth()->id(),
            'device_id'    => 'required|max:250',
            'device_type'  => 'in:ios,android,web',
            'old_password' => 'required|min:6|max:100',
            'password'     => 'required|min:6|max:100|same:password_confirmation',
            'password_confirmation' => 'required|min:6|max:100',
        ];
    }

    public function withValidator($validator) {
        $validator->after(function ($validator) {

            if ($this->has('old_password') && !Hash::check($this->old_password, auth()->user()->password)) {
                $validator->errors()->add('old_password', trans('auth.incorrect_old_pass'));
            }

            if($this->has('old_password') && Hash::check($this->password,auth()->user()->password)){
                $validator->errors()->add('old_password',trans('auth.same_password'));
            }
        });
    }

    protected function passedValidation()
    {
        $this->replace([
            'password' => $this->validated('password'),
            'country_code' => $this->validated('country_code'),
            'phone' => $this->validated('phone')
            ]);
    }
}
