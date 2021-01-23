<?php

namespace App\Domain\ValueObject;

final class DisplayName
{
    private string $displayName;

    public function __construct(string $displayName)
    {
        $this->displayName = $displayName;
    }

    public function toString(): string
    {
        return $this->displayName;
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public static function fromString(string $displayName): self
    {
        return new self($displayName);
    }
}
