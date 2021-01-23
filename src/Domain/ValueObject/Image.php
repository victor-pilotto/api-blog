<?php

namespace App\Domain\ValueObject;

final class Image
{
    private string $image;

    public function __construct(string $image)
    {
        $this->image = $image;
    }

    public function toString(): string
    {
        return $this->image;
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public static function fromString(string $image): self
    {
        return new self($image);
    }
}