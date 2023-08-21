<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Api\BaseApiRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegisterRequest extends BaseApiRequest
{
    public function __construct(Request $request)
    {
        $request['phone']        = fixPhone($request['phone']);
        $request['country_code'] = fixPhone($request['country_code']);
    }
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
            'phone'        => ['required','numeric','digits_between:9,10','unique:users,phone',Rule::unique('users')->whereNull('deleted_at')],
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
