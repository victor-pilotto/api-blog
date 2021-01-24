<?php

namespace App\Domain\Repository;

use App\Domain\Entity\User;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Password;
use App\Domain\ValueObject\UserId;

interface UserRepositoryInterface
{
    public function store(User $user): void;

    public function remove(User $user): void;

    public function findAll(): array;

    public function getById(UserId $id): User;

    public function findByEmail(Email $email): ?User;

    public function findByEmailAndPassword(Email $email, Password $password): ?User;
}
