<?php
namespace App\Http\Requests\Api\Auth;
use App\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest {

  public function rules() {
    return [
      'country_code' => 'required|numeric|digits_between:2,5',
      'phone'        => 'required|numeric|digits_between:9,10|exists:users,phone,deleted_at,NULL',
      //'email'       => 'required|email|exists:users,email|max:50', // use on login with email 
      'password'    => 'required|min:6|max:100',
      'device_id'   => 'required|max:250',
      'device_type' => 'required|in:ios,android,web',
      'lang'        => 'required|in:ar,en',
    ];
  }

  public function prepareForValidation(){
    $this->merge([
      'phone' => fixPhone($this->phone),
      'country_code' => fixPhone($this->country_code),
    ]);
  }
}
