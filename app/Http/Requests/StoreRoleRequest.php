<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
            // Validation rule for the 'name' field: required, string, maximum length 250, and unique in the 'roles' table.
            'name' => 'required|string|max:250|unique:roles,name',

            // Validation rule for the 'permissions' field: required.
            'permissions' => 'required',
        ];

    }
}
