<?php

namespace App\Application\Auth\JWT;

use App\Application\Auth\AuthenticationInterface;
use App\Application\Auth\Exception;
use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Validation\Constraint\SignedWith;

class Authentication implements AuthenticationInterface
{
    private Configuration $config;

    public function __construct(Configuration $config)
    {
        $this->config = $config;
    }

    public function generateToken(User $user): string
    {
        return $this->config->builder()
            ->issuedBy('blog')
            ->identifiedBy($user->id()->value())
            ->permittedFor('blog')
            ->getToken($this->config->signer(), $this->config->signingKey())
            ->toString();
    }

    public function authenticate(string $inputToken): UserId
    {
        $token = $this->config->parser()->parse($inputToken);

        $this->config->setValidationConstraints(new SignedWith($this->config->signer(), $this->config->signingKey()));

        if (! $this->config->validator()->validate($token, ...$this->config->validationConstraints())) {
            throw Exception\TokenInvalido::fromInvalido();
        }

        return UserId::fromInt($token->claims()->get('jti'));
    }
}
