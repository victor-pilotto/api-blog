<?php

namespace App\Infrastructure\Doctrine;

use App\Domain\DTO\BuscaPostPorFiltroDTO;
use App\Domain\Entity\Post;
use App\Domain\Exception;
use App\Domain\Repository\PostRepositoryInterface;
use App\Domain\ValueObject\PostId;
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

    public function remove(Post $post): void
    {
        $this->entityManager->remove($post);
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

    public function findByBuscaPostPorFiltroDto(BuscaPostPorFiltroDTO $buscaPostPorFiltroDto): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder
            ->select('p')
            ->from(Post::class, 'p')
            ->where('p.title LIKE :query')
            ->orWhere('p.content LIKE :query')
            ->setParameter(
                'query',
                '%' . $buscaPostPorFiltroDto->getQueryParams() . '%',
            );

        return $queryBuilder->getQuery()->execute();
    }
}
