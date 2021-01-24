<?php

namespace App\Domain\Service;

use App\Domain\DTO\ExcluiPostDTO;
use App\Domain\Entity\Post;
use App\Domain\Entity\User;
use App\Domain\Exception;
use App\Domain\Repository\PostRepositoryInterface;
use App\Domain\ValueObject\PostId;

class ExcluirPost
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function excluir(ExcluiPostDTO $excluiDto): Post
    {
        $post = $this->postRepository->getById(PostId::fromInt($excluiDto->getPostId()));
        $this->verificaSeAutorEstaEditando($post, $excluiDto->getUser());

        $this->postRepository->remove($post);

        return $post;
    }

    private function verificaSeAutorEstaEditando(Post $post, User $user): void
    {
        if ($post->user() !== $user) {
            throw Exception\UserNaoAutorizadoException::execute();
        }
    }
}
