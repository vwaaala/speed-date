<?php

namespace App\Http\Requests;

use App\Rules\UserStatusRule;
use App\Rules\ValidRole;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the users is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Validation rule for the 'name' field: required, string, maximum length 250 characters.
            'name' => 'required|string|max:250',

            // Validation rule for the 'email' field: required, string, valid email format, maximum length 250 characters, and unique in the 'users' table.
            'email' => 'required|string|email:rfc,dns|max:250|unique:users,email',

            // Validation rule for the 'password' field: required, string, minimum length 6 characters, and confirmation field must match.
            'password' => 'required|string|min:6|confirmed',

            // Validation rule for the 'status' field: required, using the UserStatusRule custom rule.
            'status' => ['required', new UserStatusRule],

            // Validation rule for the 'role' field: required, using the ValidRole custom rule.
            'role' => ['required', new ValidRole],
        ];

    }
}
