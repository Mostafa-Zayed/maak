<?php

namespace App\Http\Requests\Api\Provider;

use App\Http\Requests\Api\BaseApiRequest;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends BaseApiRequest
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
    public function rules(): array
    {
        return [
            'name'         => 'required|min:3|max:100',
            'country_code' => 'required|numeric|digits_between:2,5',
            'phone'        => ['required','numeric','digits_between:9,10','unique:providers,phone',Rule::unique('providers')->whereNull('deleted_at')],
            'password'     => 'required|min:6|max:100|same:password_confirmation',
            'password_confirmation' => 'required|min:6|max:100',
            'category_id' => ['nullable','exists:categories,id'],
            'city' => ['nullable'],
            'bank_account' => ['required','unique:providers,bank_account'],
            'is_conditions' => ['required','in:1'],
            'code' => 'nullable',
            'code_expire' => 'nullable'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'code' => '1234',
            'code_expire' => Carbon::now()->addMinute(),
        ]);
    }
}
