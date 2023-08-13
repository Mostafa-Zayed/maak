<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\BaseRequest;

class forgetPasswordSendCodeRequest extends BaseRequest
{
    public function rules() {
        return [
            'country_code' => 'required|exists:users,country_code',
            'phone'        => 'required|exists:users,phone',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'phone' => fixPhone($this->phone),
            'country_code' => fixPhone($this->country_code),
        ]);
    }

}
