<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\BaseRequest;
use JetBrains\PhpStorm\ArrayShape;

class ChangePhoneCheckCodeRequest extends BaseRequest
{
    #[ArrayShape(['code' => "string", 'country_code' => "string", 'phone' => "string"])] public function rules() {
        return [
            'code' => 'required',
            'country_code' => 'required|exists:users,country_code',
            'phone'        => 'numeric|digits_between:9,10|required|unique:users,phone'
        ];
    }
}
