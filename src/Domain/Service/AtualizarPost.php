<?php

namespace App\Domain\Service;

use App\Domain\DTO\AtualizaDTO;
use App\Domain\Entity\Post;
use App\Domain\Repository\PostRepositoryInterface;
use App\Domain\ValueObject\Content;
use App\Domain\ValueObject\PostId;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\UserId;
use App\Domain\Exception;

class AtualizarPost
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function atualizar(AtualizaDTO $atualizaDto): Post
    {
        $post = $this->postRepository->getById(PostId::fromInt($atualizaDto->getPostId()));
        $this->verificaSeAutorEstaEditando($post, $atualizaDto->getUserId());

        $post->atualiza(
            Title::fromString($atualizaDto->getTitle()),
            Content::fromString($atualizaDto->getContent())
        );

        $this->postRepository->store($post);

        return $post;
    }

    private function verificaSeAutorEstaEditando(Post $post, UserId $userId): void
    {
        if (!$post->user()->id()->equals($userId)) {
            throw Exception\UserNaoAutorizadoException::execute();
        }
    }
}