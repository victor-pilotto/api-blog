<?php

namespace App\Domain\ValueObject;

final class PostId
{
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function value(): int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return (string) $this->value();
    }

    public static function fromInt(int $id): self
    {
        return new self($id);
    }

    public function equals(self $id): bool
    {
        return $id->value() === $this->value();
    }
}