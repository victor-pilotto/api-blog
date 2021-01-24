<?php

namespace App\Domain\DTO;

use App\Domain\Entity\User;
use Assert\Assertion;

class ExcluiPostDTO
{
    private function __construct(
        private int $postId,
        private User $user
    ) {
    }

    public function getPostId(): int
    {
        return $this->postId;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public static function fromArray(array $params): self
    {
        Assertion::integerish($params['postId'], '"postId" needs to be integer');

        return new self(
            $params['postId'],
            $params['user']
        );
    }
}
