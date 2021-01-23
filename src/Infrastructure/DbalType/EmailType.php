<?php

namespace App\Infrastructure\DbalType;

use App\Domain\ValueObject\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\TextType;

final class EmailType extends TextType
{
    public const NAME = Email::class;

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value ? Email::fromString($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof Email) {
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
