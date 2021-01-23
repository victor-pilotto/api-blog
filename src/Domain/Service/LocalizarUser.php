<?php

namespace App\Domain\Service;

use App\Domain\DTO\LoginDTO;
use App\Domain\Entity\User;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Password;
use App\Domain\Exception;

class LocalizarUser
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function localizar(LoginDTO $loginDTO): User
    {
        $user = $this->userRepository->findByEmailAndPassword(
            Email::fromString($loginDTO->getEmail()),
            Password::fromString($loginDTO->getPassword())
        );

        if ($user instanceof User) {
            return $user;
        }

        throw Exception\LoginComCamposInvalidos::execute();
    }
}