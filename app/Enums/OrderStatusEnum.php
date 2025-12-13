<?php

namespace App\Enums;

enum OrderStatusEnum : int
{
    case PENDING        = 1;
    case APPROVED       = 2;
    case IMPLMENTATION  = 3;
    case COMPLETED      = 4;
    case CANCELLED      = 5;



    public static function labels(): array
    {
        return [
            1 => 'pending',
            2 => 'approved',
            3 => 'implementation',
            4 => 'completed',
            5 => 'cancelled',

        ];
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }


    public static function label(self|string|null $value): string
    {
        $key = $value instanceof self ? $value->value : $value;
        return self::labels()[$key] ?? (string)($key ?? '');
    }
}
