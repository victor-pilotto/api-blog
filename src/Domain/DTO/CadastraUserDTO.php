<?php

namespace App\Domain\DTO;

use Assert\Assertion;

class CadastraUserDTO
{
    private const DISPLAY_NAME_MIN_CARACTERES = 8;
    private const PASSWORD_MIN_CARACTERES = 6;

    private function __construct(
        private string $displayName,
        private string $email,
        private string $password,
        private ?string $image,
    ) {}

    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public static function fromArray(array $params): self
    {
        Assertion::keyIsset(
            $params,
            'displayName',
            sprintf('"displayName" length must be at least %s characters long', self::DISPLAY_NAME_MIN_CARACTERES)
        );
        Assertion::minLength(
            $params['displayName'],
            self::DISPLAY_NAME_MIN_CARACTERES,
            sprintf('"displayName" length must be at least %s characters long', self::DISPLAY_NAME_MIN_CARACTERES)
        );

        Assertion::keyIsset($params, 'email', '"email" is required');
        Assertion::email($params['email'], '"email" must be a valid email');

        Assertion::keyIsset($params, 'password', '"password" is required');
        Assertion::minLength($params['password'],
            self::PASSWORD_MIN_CARACTERES,
            sprintf('"password" length must be at least %s characters long', self::PASSWORD_MIN_CARACTERES)
        );

        return new self(
            $params['displayName'],
            $params['email'],
            $params['password'],
            $params['image'] ?? null
        );
    }

}