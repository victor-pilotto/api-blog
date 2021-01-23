<?php

namespace App\Infrastructure\DbalType;

use App\Domain\ValueObject\DisplayName;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\TextType;

final class DisplayNameType extends TextType
{
    public const NAME = DisplayName::class;

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value ? DisplayName::fromString($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof DisplayName) {
            return $value->toString();
        }
        return $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
