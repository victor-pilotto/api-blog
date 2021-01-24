<?php

namespace Test\Domain\Service;

use App\Domain\DTO\ExcluiPostDTO;
use App\Domain\Entity\Post;
use App\Domain\Entity\User;
use App\Domain\Exception\UserNaoAutorizadoException;
use App\Domain\Repository\PostRepositoryInterface;
use App\Domain\Service\ExcluirPost;
use App\Domain\ValueObject\PostId;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ExcluirPostTest extends TestCase
{
    private MockObject $postRepository;
    private MockObject $excluiPostDto;
    private MockObject $post;
    private MockObject $user;
    private ExcluirPost $excluirPost;

    public function setUp(): void
    {
        $this->postRepository = $this->getMockForAbstractClass(PostRepositoryInterface::class);
        $this->excluiPostDto  = $this->getMockBuilder(ExcluiPostDTO::class)
            ->disableOriginalConstructor()->getMock();
        $this->post           = $this->getMockBuilder(Post::class)
            ->disableOriginalConstructor()->getMock();
        $this->user           = $this->getMockBuilder(User::class)
            ->disableOriginalConstructor()->getMock();

        $this->excluirPost = new ExcluirPost($this->postRepository);
    }

    /** @test */
    public function atualizarDeveFuncionar(): void
    {
        $params = [
            'postId' => random_int(1, 999),
            'user'   => $this->user,
        ];

        $this->excluiPostDto
            ->expects(self::once())
            ->method('getPostId')
            ->willReturn($params['postId']);

        $this->excluiPostDto
            ->expects(self::once())
            ->method('getUser')
            ->willReturn($params['user']);

        $this->post
            ->expects(self::once())
            ->method('user')
            ->willReturn($this->user);

        $this->postRepository
            ->expects(self::once())
            ->method('getById')
            ->with(PostId::fromInt($params['postId']))
            ->willReturn($this->post);

        $this->postRepository
            ->expects(self::once())
            ->method('remove');

        $this->excluirPost->excluir($this->excluiPostDto);
    }

    /** @test */
    public function atualizaDeveRetornarExceptionSeUsuarioDiferenteDoAutor(): void
    {
        $this->expectException(UserNaoAutorizadoException::class);

        $params = [
            'postId' => random_int(1, 999),
            'user'   => $this->getMockBuilder(User::class)->disableOriginalConstructor()->getMock(),
        ];

        $this->excluiPostDto
            ->expects(self::once())
            ->method('getPostId')
            ->willReturn($params['postId']);

        $this->excluiPostDto
            ->expects(self::once())
            ->method('getUser')
            ->willReturn($params['user']);

        $this->post
            ->expects(self::once())
            ->method('user')
            ->willReturn($this->user);

        $this->postRepository
            ->expects(self::once())
            ->method('getById')
            ->with(PostId::fromInt($params['postId']))
            ->willReturn($this->post);

        $this->excluirPost->excluir($this->excluiPostDto);
    }
}
