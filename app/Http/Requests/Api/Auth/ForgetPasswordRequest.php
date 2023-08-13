<?php

namespace App\Http\Requests\Api\Auth;

use App\Models\User;
use App\Models\UserUpdate;
use App\Http\Requests\BaseRequest;

class ForgetPasswordRequest extends BaseRequest {

  public function rules() {
    return [
      'code'         => 'required|max:10',
      'country_code' => 'required|exists:users,country_code',
      'phone'        => 'required|exists:users,phone',
      'password'     => 'required|min:6|max:100',
    ];
  }

  public function prepareForValidation()
  {
    $this->merge([
      'phone' => fixPhone($this->phone),
      'country_code' => fixPhone($this->country_code),
    ]);
  }

  public function withValidator($validator)
  {
    $validator->after(function ($validator) {
      $user = User::where(['phone' => $this->phone, 'country_code' => $this->country_code])->first();
      if (!$user) {
        $validator->errors()->add('not_user', trans('auth.failed'));
      }
      $update = UserUpdate::where(['user_id' => $user->id, 'type' => 'password', 'code' => $this->code])->first();
      if (!$update) {
        $validator->errors()->add('not_user', trans('auth.code_invalid'));
      }
    });
  }
}
