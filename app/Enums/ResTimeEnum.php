<?php

namespace App\Enums;

enum ResTimeEnum : int
{
    case IMMEDIATE = 1;
    case SCHEDULE  = 2;


    public static function labels() : array{
      return [

          1  => 'immediate' ,
          2  => 'schedule' ,
      ];
    }

    public static function values()  {
        return array_column(self::cases() , 'value');
    }

    public static function label(self|string|null $value): string
    {
        $key = $value instanceof self ? $value->value : $value;
        return self::labels()[$key] ?? (string)($key ?? '');
    }


}
