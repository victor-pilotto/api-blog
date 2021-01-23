<?php

namespace App\Domain\DTO;

use Assert\Assertion;

class LoginDTO
{
    private function __construct(
        private string $email,
        private string $password
    ) {}

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public static function fromArray(array $params): self
    {
        Assertion::keyIsset($params, 'email', '"email" is required');
        Assertion::notEmpty($params['email'], '"email" is not allowed to be empty');

        Assertion::keyIsset($params, 'password', '"password" is required');
        Assertion::notEmpty($params['password'], '"password" is not allowed to be empty');

        return new self(
            $params['email'],
            $params['password']
        );
    }
}