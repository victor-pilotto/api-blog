<?php

namespace App\Infrastructure\Doctrine;

use App\Domain\Entity\Post;
use App\Domain\Entity\User;
use App\Domain\Repository\PostRepositoryInterface;
use App\Domain\ValueObject\PostId;
use App\Domain\ValueObject\UserId;
use Doctrine\ORM\EntityManager;
use App\Domain\Exception;

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

    public function findAll(): array
    {
        return $this->entityManager->getRepository(Post::class)->findAll();
    }

    public function getById(PostId $id): Post
    {
        $post = $this->entityManager->getRepository(Post::class)->find($id);

        if ($post instanceof Post) {
            return $post;
        }

        throw Exception\PostNaoExisteException::execute();
    }
}