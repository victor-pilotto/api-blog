<?php

namespace App\Domain\Repository;

use App\Domain\Entity\User;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Password;

interface UserRepositoryInterface
{
    public function store(User $user): void;

    public function findAll(): array;

    public function findByEmail(Email $email): ?User;

    public function findByEmailAndPassword(Email $email, Password $password): ?User;
}
