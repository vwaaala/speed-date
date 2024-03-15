<?php

namespace Bunker\LaravelSpeedDate\Enums;

use ReflectionClass;

/**
 * Class UserStatusEnum
 *
 * This class represents the enumeration of user statuses.
 */
class EventTypeEnum
{
    // Constants representing user statuses
    const GAY = 'gay';
    const STRAIGHT = 'straight';

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
