<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Spatie\Permission\Models\Role;

/**
 * Class ValidRole
 *
 * This class implements a validation rule for checking the existence of a role.
 */
class ValidRole implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute The name of the attribute being validated.
     * @param  mixed  $value The value of the attribute being validated.
     * @return bool True if the validation passes, otherwise false.
     */
    public function passes($attribute, $value)
    {
        // Check if the role exists in the roles table
        return Role::where('name', $value)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string The validation error message.
     */
    public function message()
    {
        return 'The selected role is invalid.';
    }
}
