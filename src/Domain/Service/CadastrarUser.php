<?php

namespace App\Domain\Service;

use App\Domain\DTO\CadastraUserDTO;
use App\Domain\Entity\User;
use App\Domain\Exception;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\ValueObject\DisplayName;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Image;
use App\Domain\ValueObject\Password;

class CadastrarUser
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function cadastrar(CadastraUserDTO $cadastraUserDto): User
    {
        $email = Email::fromString($cadastraUserDto->getEmail());
        $this->verificaSeUsuarioExiste($email);

        $user = User::novo(
            DisplayName::fromString($cadastraUserDto->getDisplayName()),
            $email,
            Password::fromString($cadastraUserDto->getPassword()),
            $cadastraUserDto->getImage() !== null ? Image::fromString($cadastraUserDto->getImage()) : null
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
