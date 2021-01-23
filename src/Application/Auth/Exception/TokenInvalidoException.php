<?php

namespace App\Application\Auth\Exception;

use Exception;

class TokenInvalidoException extends Exception
{
    public static function fromInvalido(): self
    {
        return new self('Token expirado ou inválido');
    }
}
