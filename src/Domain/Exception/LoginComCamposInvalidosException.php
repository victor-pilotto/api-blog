<?php

namespace App\Domain\Exception;

use InvalidArgumentException;

class LoginComCamposInvalidosException extends InvalidArgumentException
{
    public static function execute(): self
    {
        return new self('Campos inválidos');
    }
}
