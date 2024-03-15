<?php

namespace App\Enums;

use ReflectionClass;

/**
 * Class UserStatusEnum
 *
 * This class represents the enumeration of user statuses.
 */
class UserStatusEnum
{
    // Constants representing user statuses
    const PENDING = 'pending';
    const ACTIVE = 'active';
    const INACTIVE = 'inactive';
    const BANNED = 'banned';

    /**
     * Get all constants as an array.
     *
     * @return array An array containing all the constants defined in this class.
     */
    public static function toArray(): array
    {
        // Use reflection to get constants defined in this class
        $class = new ReflectionClass(static::class);
        return $class->getConstants();
    }
}
