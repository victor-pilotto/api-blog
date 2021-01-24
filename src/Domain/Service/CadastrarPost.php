<?php

namespace App\Domain\Service;

use App\Domain\DTO\CadastraPostDTO;
use App\Domain\Entity\Post;
use App\Domain\Repository\PostRepositoryInterface;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\ValueObject\Content;
use App\Domain\ValueObject\Title;

class CadastrarPost
{
    private PostRepositoryInterface $postRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct(
        PostRepositoryInterface $postRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
    }

    public function cadastrar(CadastraPostDTO $cadastraPostDTO): Post
    {
        $user = $this->userRepository->getById($cadastraPostDTO->getUserId());

        $post = Post::novo(
            Title::fromString($cadastraPostDTO->getTitle()),
            Content::fromString($cadastraPostDTO->getContent()),
            $user
        );

        $this->postRepository->store($post);

        return $post;
    }
}