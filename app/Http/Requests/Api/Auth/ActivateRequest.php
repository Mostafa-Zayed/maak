<?php

namespace App\Http\Requests\Api\Auth;

use App\Models\User;
use App\Traits\GeneralTrait;
use App\Http\Requests\BaseRequest;

class ActivateRequest extends BaseRequest {
  use GeneralTrait;

  public function rules() {
    return [
      'code'         => 'required|max:10',
      'country_code' => 'required|exists:users,country_code',
      'phone'        => 'required|exists:users,phone',
      'device_id'    => 'required|max:250',
      'device_type'  => 'in:ios,android,web',
    ];
  }

  public function prepareForValidation()
  {
    $this->merge([
      'phone' => fixPhone($this->phone),
      'country_code' => fixPhone($this->country_code),
    ]);
  }

  public function withValidator($validator){
    $validator->after(function ($validator) {
      
      $user = User::where(['phone' => $this->phone, 'country_code' => $this->country_code])->first()  ;

      if (!$user) {
        $validator->errors()->add('not_user', trans('auth.failed'));
      }

      if (!$this->isCodeCorrect($user, $this->code)) {
        $validator->errors()->add('wrong_code', trans('auth.code_invalid'));
      }

    });
  }

}
