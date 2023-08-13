<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\BaseRequest;

class changePhoneCheckCodeRequest extends BaseRequest
{
    public function rules() {
        return [
            'code' => 'required',
        ];
    }
}
