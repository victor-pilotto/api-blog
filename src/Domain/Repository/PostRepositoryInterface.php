<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Post;
use App\Domain\ValueObject\PostId;

interface PostRepositoryInterface
{
    public function store(Post $post): void;

    public function findAll(): array;

    public function getById(PostId $id): Post;
}