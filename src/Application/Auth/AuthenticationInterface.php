<?php

namespace App\Application\Auth;

use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;

interface AuthenticationInterface
{
    public function authenticate(string $inputToken): UserId;

    public function generateToken(User $user): string;
}