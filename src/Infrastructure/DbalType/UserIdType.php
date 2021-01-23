<?php

namespace App\Infrastructure\DbalType;

use App\Domain\ValueObject\UserId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;

final class UserIdType extends IntegerType
{
    public const NAME = UserId::class;

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value ? UserId::fromInt($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof UserId) {
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
