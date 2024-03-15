<?php

namespace Bunker\LaravelSpeedDate\Enums;

use ReflectionClass;

/**
 * Class UserStatusEnum
 *
 * This class represents the enumeration of user statuses.
 */
class RatingEnum
{
    // Constants representing user statuses
    const MAYBE = 'maybe';
    const NO = 'no';
    const YES = 'yes';

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
