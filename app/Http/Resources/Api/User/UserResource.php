<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class UserResource extends JsonResource
{
    private $token               = '';

    public function setToken($value) {
        $this->token = $value;
        return $this;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['id' => "mixed", 'name' => "mixed", 'email' => "mixed", 'country_code' => "mixed", 'phone' => "mixed", 'token' => "string"])] public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->id,
            'name'                => $this->name,
            'email'               => $this->email,
            'country_code'        => $this->country_code,
            'phone'               => $this->phone,
            'token'               => $this->token,
        ];
    }
}
