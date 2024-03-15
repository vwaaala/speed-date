<?php

namespace App\Rules;

use App\Enums\UserStatusEnum;
use Illuminate\Contracts\Validation\Rule;

/**
 * Class UserStatusRule
 *
 * This class implements a validation rule for user status enumeration.
 */
class UserStatusRule implements Rule
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
        // Check if the value is one of the constants defined in the UserStatusEnum class.
        return in_array($value, array_values((new \ReflectionClass(UserStatusEnum::class))->getConstants()));
    }

    /**
     * Get the validation error message.
     *
     * @return string The validation error message.
     */
    public function message()
    {
        return 'The selected :attribute is invalid.';
    }
}
