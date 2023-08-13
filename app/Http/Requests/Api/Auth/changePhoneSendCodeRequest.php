<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\BaseRequest;

class changePhoneSendCodeRequest extends BaseRequest
{
    public function rules() {
        return [
            'country_code' => 'required|exists:users,country_code',
            'phone'        => 'required|unique:users,phone',
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
