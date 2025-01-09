<?php

namespace App\Infrastructure\DBAL\Type;

use App\Domain\ValueObject\UuidValueObject;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class UuidType extends GuidType
{
    public const NAME = 'uuid';

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): mixed
    {
        if (null === $value) {
            return null;
        }
        if ($value instanceof UuidValueObject) {
            return (string)$value;
        }
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): mixed
    {
        return empty($value) ? $value : new UuidValueObject($value);
    }


}