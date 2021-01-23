<?php

namespace App\Domain\Service;

use App\Domain\DTO\LoginDTO;
use App\Domain\Entity\User;
use App\Domain\Exception;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Password;

class LocalizarUser
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function localizar(LoginDTO $loginDto): User
    {
        $user = $this->userRepository->findByEmailAndPassword(
            Email::fromString($loginDto->getEmail()),
            Password::fromString($loginDto->getPassword())
        );

        if ($user instanceof User) {
            return $user;
        }

        throw Exception\LoginComCamposInvalidosException::execute();
    }
}
