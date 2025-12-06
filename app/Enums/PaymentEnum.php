<?php

namespace App\Enums;
enum PaymentEnum: int
{
    case PAYPAL      = 1;
    case STRIPE      = 2;
    case PAYTABS     = 3;
    case TAP_PAYMENT = 4;
    case FAWRY       = 5;
    case PAYFORT     = 6;
    case MADA        = 7;
    case MEEZA       = 8;
    case KNET        = 9;


    public static function labels(): array
    {
        return [
            1 => 'paypal',
            2 => 'stripe',
            3 => 'paytabs',
            4 => 'tap_payment',
            5 => 'fawry',
            6 => 'payfort',
            7 => 'mada',
            8 => 'meeza',
            9 => 'knet',
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
