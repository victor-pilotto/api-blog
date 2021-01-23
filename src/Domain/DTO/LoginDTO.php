<?php

namespace App\Domain\DTO;

use Assert\Assertion;

class LoginDTO
{
    private const PASSWORD_MIN_CARACTERES = 6;

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
        Assertion::email($params['email'], '"email" must be a valid email');

        Assertion::keyIsset($params, 'password', '"password" is required');
        Assertion::minLength($params['password'],
            self::PASSWORD_MIN_CARACTERES,
            sprintf('"password" length must be at least %s characters long', self::PASSWORD_MIN_CARACTERES)
        );

        return new self(
            $params['email'],
            $params['password']
        );
    }
}