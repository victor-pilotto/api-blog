<?php

namespace App\Domain\DTO;

use App\Domain\ValueObject\UserId;
use Assert\Assertion;

class AtualizaDTO
{
    private function __construct(
        private int $postId,
        private string $title,
        private string $content,
        private UserId $userId
    ) {
    }

    public function getPostId(): int
    {
        return $this->postId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public static function fromArray(array $params): self
    {
        Assertion::integerish($params['postId'], '"postId" needs to be integer');

        Assertion::keyIsset($params, 'title', '"title" is required');
        Assertion::notEmpty($params['title'], '"title" is required');

        Assertion::keyIsset($params, 'content', '"content" is required');
        Assertion::notEmpty($params['content'], '"content" is required');

        return new self(
            $params['postId'],
            $params['title'],
            $params['content'],
            $params['userId']
        );
    }
}