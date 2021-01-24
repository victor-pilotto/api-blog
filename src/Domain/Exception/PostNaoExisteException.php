<?php

namespace App\Domain\Exception;

class PostNaoExisteException extends \Exception
{
    public static function execute(): self
    {
        return new self('Post não existe');
    }
}