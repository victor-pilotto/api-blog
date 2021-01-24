<?php

namespace App\Domain\Service;

use App\Domain\DTO\CadastraPostDTO;
use App\Domain\Entity\Post;
use App\Domain\Repository\PostRepositoryInterface;
use App\Domain\ValueObject\Content;
use App\Domain\ValueObject\Title;

class CadastrarPost
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function cadastrar(CadastraPostDTO $cadastraPostDto): Post
    {
        $post = Post::novo(
            Title::fromString($cadastraPostDto->getTitle()),
            Content::fromString($cadastraPostDto->getContent()),
            $cadastraPostDto->getUser()
        );

        $this->postRepository->store($post);

        return $post;
    }
}
