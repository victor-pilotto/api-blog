<?php

namespace App\Domain\Exception;

use Exception;

class UserNaoAutorizadoException extends Exception
{
    public static function execute(): self
    {
        return new self('Usuário não autorizado');
    }
}