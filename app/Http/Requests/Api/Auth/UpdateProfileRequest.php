<?php
namespace App\Http\Requests\Api\Auth;
use App\Http\Requests\BaseRequest;
class UpdateProfileRequest extends BaseRequest {
  public function rules() {
    return [
      'name'         => 'sometimes|required|max:50|unique:users,name,' . auth()->id(),
      'email'        => 'sometimes|required|email|max:50|unique:users,email,' . auth()->id(),
    ];
  }

}
