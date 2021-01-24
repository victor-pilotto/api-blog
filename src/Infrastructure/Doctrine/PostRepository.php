<?php

namespace App\Infrastructure\Doctrine;

use App\Domain\Entity\Post;
use App\Domain\Repository\PostRepositoryInterface;
use Doctrine\ORM\EntityManager;

class PostRepository implements PostRepositoryInterface
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function store(Post $post): void
    {
        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }
}