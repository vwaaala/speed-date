<?php

namespace App\Http\Requests;

use App\Rules\ValidDomain;
use Illuminate\Foundation\Http\FormRequest;

class SettingsGeneralUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'logo' => 'file|mimes:png',
            'domain' => ['required', new ValidDomain],
            'avatar' => 'file|mimes:jpg',
            'email' => 'required|email',
            'phone' => 'required',
            'street' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
        ];
    }
}
