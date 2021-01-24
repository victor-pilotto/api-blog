<?php

namespace App\Domain\ValueObject;

use DateTimeImmutable;

final class Published extends DateTimeImmutable
{
    private DateTimeImmutable $updated;

    public function value(): DateTimeImmutable
    {
        return $this->updated;
    }

    public static function fromString(string $updated): self
    {
        $instance          = new self();
        $instance->updated = new DateTimeImmutable($updated);
        return $instance;
    }

    public static function agora(): self
    {
        $instance          = new self();
        $instance->updated = new DateTimeImmutable();
        return $instance;
    }
}
