<?php

namespace Test\Domain\Service;

use App\Domain\DTO\CadastraPostDTO;
use App\Domain\Entity\User;
use App\Domain\Repository\PostRepositoryInterface;
use App\Domain\Service\CadastrarPost;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CadastrarPostTest extends TestCase
{
    private MockObject $postRepository;
    private MockObject $cadastraPostDto;
    private MockObject $user;
    private CadastrarPost $cadastrarPost;

    public function setUp(): void
    {
        $this->postRepository = $this->getMockForAbstractClass(PostRepositoryInterface::class);

        $this->cadastraPostDto = $this->getMockBuilder(CadastraPostDTO::class)
            ->disableOriginalConstructor()->getMock();
        $this->user            = $this->getMockBuilder(User::class)
            ->disableOriginalConstructor()->getMock();

        $this->cadastrarPost = new CadastrarPost($this->postRepository);
    }

    /** @test */
    public function cadastrarDeveFuncionar(): void
    {
        $params = [
            'title'   => 'Latest updates, August 1st',
            'content' => 'The whole text for the blog post goes here in this key',
            'user'    => $this->getMockBuilder(User::class)->disableOriginalConstructor()->getMock(),
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
            ->method('getUser')
            ->willReturn($params['user']);

        $this->postRepository
            ->expects(self::once())
            ->method('store');

        $this->cadastrarPost->cadastrar($this->cadastraPostDto);
    }
}
