<?php

namespace App\Http\Requests;

use App\Rules\UserStatusRule;
use App\Rules\ValidRole;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $rules = [
            // Validation rule for the 'name' field: required, string, maximum length 250 characters.
            'name' => 'required|string|max:250',

            // Validation rule for the 'status' field: required, using the UserStatusRule custom rule.
            'status' => [new UserStatusRule],

            // Validation rule for the 'role' field: required, using the ValidRole custom rule.
            'role' => [new ValidRole],
            'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ];

        // If 'avatar' field is present in the request, apply the validation rules
        // Otherwise, remove the 'avatar' field from the rules array
        if (!$this->hasFile('avatar')) {
            unset($rules['avatar']);
        }

        return $rules;

    }
}
