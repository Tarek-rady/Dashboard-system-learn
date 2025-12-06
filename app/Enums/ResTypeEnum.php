<?php

namespace App\Enums;

enum ResTypeEnum : int
{


    case HOME = 1;
    case SHOP  = 2;


    public static function labels() : array{
      return [

          1  => 'home' ,
          2  => 'shop' ,
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
