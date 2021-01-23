<?php

namespace App\Infrastructure\DbalType;

use App\Domain\ValueObject\PostId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;

final class PostIdType extends IntegerType
{
    public const NAME = PostId::class;

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value ? PostId::fromInt($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof PostId) {
            return $value->value();
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
