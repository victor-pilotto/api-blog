<?php

namespace App\Application\Auth\JWT;

use App\Application\Auth\AuthenticationInterface;
use App\Application\Auth\Exception;
use App\Domain\Entity\User;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\ValueObject\UserId;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\Validation\Constraint\SignedWith;

class Authentication implements AuthenticationInterface
{
    private Configuration $config;
    private UserRepositoryInterface $userRepository;

    public function __construct(
        Configuration $config,
        UserRepositoryInterface $userRepository
    ) {
        $this->config         = $config;
        $this->userRepository = $userRepository;
    }

    public function generateToken(User $user): string
    {
        return $this->config->builder()
            ->issuedBy('blog')
            ->identifiedBy((string) $user->id()->value())
            ->permittedFor('blog')
            ->getToken($this->config->signer(), $this->config->signingKey())
            ->toString();
    }

    public function authenticate(string $inputToken): User
    {
        if (empty($inputToken)) {
            throw Exception\TokenNaoEncontradoException::execute();
        }

        try {
            $token = $this->config->parser()->parse($inputToken);

            $this->config->setValidationConstraints(
                new SignedWith($this->config->signer(), $this->config->signingKey())
            );

            if (! $this->config->validator()->validate($token, ...$this->config->validationConstraints())) {
                throw Exception\TokenInvalidoException::fromInvalido();
            }

            assert($token instanceof Token\Plain);

            $userId = UserId::fromInt($token->claims()->get('jti'));

            return $this->userRepository->getById($userId);
        } catch (\Exception $e) {
            throw Exception\TokenInvalidoException::fromInvalido();
        }
    }
}
