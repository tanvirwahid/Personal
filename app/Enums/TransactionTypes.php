<?php

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self deposit()
 * @method static self widrawal()
 */
class TransactionTypes extends Enum
{
    protected static function values(): array
    {
        return [
            'deposit' => 0,
            'widrawal' => 1,
        ];
    }
}
