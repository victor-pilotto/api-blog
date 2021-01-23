<?php

namespace App\Infrastructure\DbalType;

use App\Domain\ValueObject\Title;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\TextType;

final class TitleType extends TextType
{
    public const NAME = Title::class;

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value ? Title::fromString($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof Title) {
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
