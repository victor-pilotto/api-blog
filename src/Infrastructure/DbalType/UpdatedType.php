<?php

namespace App\Infrastructure\DbalType;

use App\Domain\ValueObject\Updated;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeImmutableType;

final class UpdatedType extends DateTimeImmutableType
{
    public const NAME = Updated::class;

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value ? Updated::fromString($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof Updated) {
            return $value->format($platform->getDateTimeFormatString());
        }

        return $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
