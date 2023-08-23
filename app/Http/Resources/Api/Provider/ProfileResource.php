<?php

namespace App\Http\Resources\Api\Provider;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'country_code' => $this->country_code,
            'phone' => $this->phone,
            'name' => $this->name,
            'category_id' => $this->category->name ?? '',
            'city' => $this->city ?? '',
            'bank_name' => $this->bank_name ?? '',
            'bank_username' => $this->bank_username ?? '',
            'bank_iban' => $this->bank_iban ?? '',
            'bank_account' => $this->bank_account ?? '',
            'image' => $this->image ?? ''
        ];
    }
}
