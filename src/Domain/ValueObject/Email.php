<?php

namespace App\Domain\ValueObject;

final class Email
{
    private string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function toString(): string
    {
        return $this->email;
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public static function fromString(string $email): self
    {
        return new self($email);
    }
}