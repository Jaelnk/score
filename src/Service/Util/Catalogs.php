<?php

namespace App\Service\Util;
class Catalogs
{

    private static $types = [
        'ESTADO_CATALOGO' => self:: ESTADO_CATALOGO,
        'TIPO_DPA' => self:: TIPO_DPA,
        'ESTADO_DPA' => self:: ESTADO_DPA,
        'ESTADO_TELEFONO' => self:: ESTADO_TELEFONO,
        'TIPO_TELEFONO' => self:: TIPO_TELEFONO,
    ];

    const ESTADO_CATALOGO = 1;
    const TIPO_DPA = 2;
    const ESTADO_DPA = 3;
    const ESTADO_TELEFONO = 4;
    const TIPO_TELEFONO = 5;

    public static function getValues()
    {
        return self::$types;
    }

    public static function fromString($index)
    {
        return self::$types[$index];
    }

    public static function toString($value)
    {
        return array_search($value, self::$types);
    }


}