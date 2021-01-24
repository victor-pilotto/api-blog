<?php

namespace App\Infrastructure\DbalType;

use App\Domain\ValueObject\Published;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeImmutableType;

final class PublishedType extends DateTimeImmutableType
{
    public const NAME = Published::class;

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value ? Published::fromString($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof Published) {
            return $value->format($platform->getDateTimeFormatString());
        }

        return $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
