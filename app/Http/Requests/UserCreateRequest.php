<?php

namespace App\Http\Requests;

use App\Rules\PhoneRule;
use App\Rules\UniqueRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserCreateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string',
            'last_name'  => 'nullable|string',
            'phone'      => [
                'required',
                new PhoneRule(),
                new UniqueRule('users', 'phone'),
            ],
            'password'   => ['required', 'string', 'confirmed', Password::min(8)->letters()->numbers()],
            'avatar'     => 'image',
            'roles'      => 'array',
            'roles.*'    => 'nullable|exists:roles,name|not_in:superadmin',
        ];
    }
}
