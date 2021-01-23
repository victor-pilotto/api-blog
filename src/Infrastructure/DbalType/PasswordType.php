<?php

namespace App\Infrastructure\DbalType;

use App\Domain\ValueObject\Password;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\TextType;

final class PasswordType extends TextType
{
    public const NAME = Password::class;

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value ? Password::fromString($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof Password) {
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
