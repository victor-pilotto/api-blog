<?php

namespace App\Domain\ValueObject;

final class Password
{
    private string $password;

    public function __construct(string $password)
    {
        $this->password = md5($password);
    }

    public function toString(): string
    {
        return $this->password;
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public static function fromString(string $password): self
    {
        return new self($password);
    }
}
