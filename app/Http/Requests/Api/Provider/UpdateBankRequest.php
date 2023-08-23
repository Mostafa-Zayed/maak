<?php

namespace App\Http\Requests\Api\Provider;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class UpdateBankRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    #[ArrayShape(['bank_account' => "string", 'bank_name' => "string", 'bank_username' => "string", 'bank_iban' => "string"])] public function rules(): array
    {
        return [
            'bank_account' => 'required',
            'bank_name' => 'required',
            'bank_username' => 'required',
            'bank_iban' => 'required'
        ];
    }
}
