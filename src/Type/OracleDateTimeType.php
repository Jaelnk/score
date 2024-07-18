<?php

namespace App\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeType;

class OracleDateTimeType extends DateTimeType
{
    const ORACLE_DATETIME = 'oracle_datetime';

    public function getName()
    {
        return self::ORACLE_DATETIME;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {

        if ($value === null) {
            return null;
        }

        return $value->format('Y-m-d H:i:s'); // Ajusta el formato según tus necesidades
    }
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        // Intenta primero con el formato más común
        $dateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $value);

        // Si el primer intento falla, prueba con el formato específico de Oracle que causa el error
        if (!$dateTime) {
            $dateTime = \DateTime::createFromFormat('d-M-y h.i.s.u A', $value);
        }

        // Si ambos intentos fallan, intenta con la creación directa
        if (!$dateTime) {
            $dateTime = new \DateTime($value);
        }

        return $dateTime;
    }


}
