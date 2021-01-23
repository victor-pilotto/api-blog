<?php

namespace App\Infrastructure\DbalType;

use App\Domain\ValueObject\Content;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\TextType;

final class ContentType extends TextType
{
    public const NAME = Content::class;

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value ? Content::fromString($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof Content) {
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
