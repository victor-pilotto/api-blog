<?php

namespace App\Application\Auth\Exception;

use Exception;

class TokenInvalidoException extends Exception
{
    public static function execute(): self
    {
        return new self('Token expirado ou inválido');
    }
}
