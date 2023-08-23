<?php

namespace App\Http\Resources\Api\Provider;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderResource extends JsonResource
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
    public function toArray(Request $request): array
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
