<?php

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self individual()
 * @method static self business()
 */
class UserTypeEnums extends Enum
{
    protected static function values(): array
    {
        return [
            'individual' => 0,
            'business' => 1,
        ];
    }
}
