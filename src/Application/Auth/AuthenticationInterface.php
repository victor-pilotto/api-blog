<?php

namespace App\Application\Auth;

use App\Domain\Entity\User;

interface AuthenticationInterface
{
    public function authenticate(string $inputToken): User;

    public function generateToken(User $user): string;
}
