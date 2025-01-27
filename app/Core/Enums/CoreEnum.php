<?php

namespace App\Core\Enums;

use App\Core\Contracts\EnumTranslateContract;
use App\Core\Traits\EnumCasts;
use App\Core\Traits\EnumTranslate;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

abstract class CoreEnum implements EnumTranslateContract, CastsAttributes
{
    use EnumCasts, EnumTranslate;

    public static function reflection()
    {
        return new \ReflectionClass(static::class);
    }

    /**
     * Returns class constant values
     */
    public static function toArray(): array
    {
        return array_values(self::reflection()->getConstants());
    }

    /**
     * Returns class constant keys
     */
    public static function getKeys(): array
    {
        return array_keys(self::reflection()->getConstants());
    }

    public function __toString(): string
    {
        return implode(',', static::toArray());
    }

    /**
     * validator enum abilities
     */
    public static function isValid(string $value): bool
    {
        return in_array($value, static::toArray());
    }
}
