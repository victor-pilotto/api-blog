<?php

namespace App\Domain\Exception;

class LoginComCamposInvalidos extends \InvalidArgumentException
{
    public static function execute(): self
    {
        return new self('Campos inválidos');
    }
}