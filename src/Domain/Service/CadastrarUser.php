<?php

namespace App\Domain\Service;

use App\Domain\DTO\CadastraUserDTO;
use App\Domain\Entity\User;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\ValueObject\DisplayName;
use App\Domain\ValueObject\Email;
use App\Domain\Exception;
use App\Domain\ValueObject\Image;
use App\Domain\ValueObject\Password;

class CadastrarUser
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function cadastrar(CadastraUserDTO $cadastraUserDTO): User
    {
        $email = Email::fromString($cadastraUserDTO->getEmail());
        $this->verificaSeUsuarioExiste($email);

        $user = User::novo(
            DisplayName::fromString($cadastraUserDTO->getDisplayName()),
            $email,
            Password::fromString($cadastraUserDTO->getPassword()),
            $cadastraUserDTO->getImage() ? Image::fromString($cadastraUserDTO->getImage()) : null
        );

        $this->userRepository->store($user);

        return $user;
    }

    private function verificaSeUsuarioExiste(Email $email): void
    {
        $user = $this->userRepository->findByEmail($email);

        if ($user) {
            throw Exception\UserJaExisteException::execute();
        }
    }
}