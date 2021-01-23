<?php

namespace App\Domain\ValueObject;

use DateTimeImmutable;

final class Published
{
    private DateTimeImmutable $published;

    private function __construct()
    {
    }

    public function value(): DateTimeImmutable
    {
        return $this->published;
    }

    public static function fromString(string $published): self
    {
        $instance               = new self();
        $instance->published = new DateTimeImmutable($published);
        return $instance;
    }

    public static function agora(): self
    {
        $instance            = new self();
        $instance->published = new DateTimeImmutable();
        return $instance;
    }
}