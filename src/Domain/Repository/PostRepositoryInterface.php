<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Post;

interface PostRepositoryInterface
{
    public function store(Post $post): void;

    public function findAll(): array;
}