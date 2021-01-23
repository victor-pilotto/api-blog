<?php

namespace App\Domain\Repository;

use App\Domain\Entity\User;
use App\Domain\ValueObject\Email;

interface UserRepositoryInterface
{
    public function store(User $user): void;

    public function findByEmail(Email $email): ?User;
}