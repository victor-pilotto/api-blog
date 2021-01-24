<?php

namespace App\Domain\Exception;

class UserNaoExisteException extends \Exception
{
    public static function execute(): self
    {
        return new self('Usuário não existe');
    }
}