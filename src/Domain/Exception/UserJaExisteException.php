<?php

namespace App\Domain\Exception;

class UserJaExisteException extends \DomainException
{
    public static function execute(): self
    {
        return new self('Usuário já existe');
    }
}