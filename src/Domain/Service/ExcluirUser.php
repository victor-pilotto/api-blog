<?php

namespace App\Domain\Service;

use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\ValueObject\UserId;

class ExcluirUser
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function excluir(UserId $id): void
    {
        $user = $this->userRepository->getById($id);
        $this->userRepository->remove($user);
    }
}