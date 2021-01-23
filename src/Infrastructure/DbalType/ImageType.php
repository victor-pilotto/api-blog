<?php

namespace App\Infrastructure\DbalType;

use App\Domain\ValueObject\Image;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\TextType;

final class ImageType extends TextType
{
    public const NAME = Image::class;

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value ? Image::fromString($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof Image) {
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
