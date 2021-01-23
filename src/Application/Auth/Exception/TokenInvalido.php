<?php

namespace App\Application\Auth\Exception;

use Exception;

class TokenInvalido extends Exception
{
    public static function fromInvalido(): self
    {
        return new self('Token expirado ou inválido');
    }
}
