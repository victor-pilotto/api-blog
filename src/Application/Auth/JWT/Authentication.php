<?php

namespace App\Application\Auth\JWT;

use App\Application\Auth\AuthenticationInterface;
use App\Application\Auth\Exception;
use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Token;
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
            ->identifiedBy((string)$user->id()->value())
            ->permittedFor('blog')
            ->getToken($this->config->signer(), $this->config->signingKey())
            ->toString();
    }

    public function authenticate(string $inputToken): UserId
    {
        if (empty($inputToken)) {
            throw Exception\TokenNaoEncontrado::execute();
        }

        try {
            $token = $this->config->parser()->parse($inputToken);

            $this->config->setValidationConstraints(new SignedWith($this->config->signer(), $this->config->signingKey()));

            if (! $this->config->validator()->validate($token, ...$this->config->validationConstraints())) {
                throw Exception\TokenInvalidoException::fromInvalido();
            }

            assert($token instanceof Token\Plain);

            return UserId::fromInt($token->claims()->get('jti'));
        } catch (\Exception $e) {
            throw Exception\TokenInvalidoException::fromInvalido();
        }
    }
}
