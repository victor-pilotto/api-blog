<?php

namespace Test\Domain\Service;

use App\Domain\DTO\CadastraPostDTO;
use App\Domain\Entity\User;
use App\Domain\Exception\UserNaoExisteException;
use App\Domain\Repository\PostRepositoryInterface;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Service\CadastrarPost;
use App\Domain\ValueObject\UserId;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CadastrarPostTest extends TestCase
{
    private MockObject $postRepository;
    private MockObject $userRepository;
    private MockObject $cadastraPostDto;
    private MockObject $user;
    private CadastrarPost $cadastrarPost;

    public function setUp(): void
    {
        $this->postRepository = $this->getMockForAbstractClass(PostRepositoryInterface::class);
        $this->userRepository = $this->getMockForAbstractClass(UserRepositoryInterface::class);

        $this->cadastraPostDto = $this->getMockBuilder(CadastraPostDTO::class)
            ->disableOriginalConstructor()->getMock();
        $this->user            = $this->getMockBuilder(User::class)
            ->disableOriginalConstructor()->getMock();

        $this->cadastrarPost = new CadastrarPost($this->postRepository, $this->userRepository);
    }

    /** @test */
    public function cadastrarDeveFuncionar(): void
    {
        $params = [
            'title'    => 'Latest updates, August 1st',
            'content' => 'The whole text for the blog post goes here in this key',
            'userId' => UserId::fromInt(random_int(1, 999))
        ];

        $this->cadastraPostDto
            ->expects(self::once())
            ->method('getTitle')
            ->willReturn($params['title']);

        $this->cadastraPostDto
            ->expects(self::once())
            ->method('getContent')
            ->willReturn($params['content']);

        $this->cadastraPostDto
            ->expects(self::once())
            ->method('getUserId')
            ->willReturn($params['userId']);

        $this->userRepository
            ->expects(self::once())
            ->method('getById')
            ->with($params['userId'])
            ->willReturn($this->user);

        $this->postRepository
            ->expects(self::once())
            ->method('store');

        $this->cadastrarPost->cadastrar($this->cadastraPostDto);
    }

    /** @test */
    public function cadastrarDeveRetornarExceptionSeEmailJaCadastrado(): void
    {
        $this->expectException(UserNaoExisteException::class);

        $params = [
            'userId' => UserId::fromInt(random_int(1, 999))
        ];

        $this->cadastraPostDto
            ->expects(self::once())
            ->method('getUserId')
            ->willReturn($params['userId']);

        $this->userRepository
            ->expects(self::once())
            ->method('getById')
            ->with($params['userId'])
            ->willThrowException(new UserNaoExisteException());

        $this->cadastrarPost->cadastrar($this->cadastraPostDto);
    }
}