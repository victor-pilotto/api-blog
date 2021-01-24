<?php

namespace Test\Domain\Service;

use App\Domain\DTO\AtualizaDTO;
use App\Domain\DTO\CadastraPostDTO;
use App\Domain\Entity\Post;
use App\Domain\Entity\User;
use App\Domain\Exception\UserNaoAutorizadoException;
use App\Domain\Exception\UserNaoExisteException;
use App\Domain\Repository\PostRepositoryInterface;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Service\AtualizarPost;
use App\Domain\Service\CadastrarPost;
use App\Domain\ValueObject\PostId;
use App\Domain\ValueObject\UserId;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class AtualizarPostTest extends TestCase
{
    private MockObject $postRepository;
    private MockObject $atualizaPostDto;
    private MockObject $post;
    private MockObject $user;
    private AtualizarPost $atualizarPost;

    public function setUp(): void
    {
        $this->postRepository = $this->getMockForAbstractClass(PostRepositoryInterface::class);
        $this->atualizaPostDto = $this->getMockBuilder(AtualizaDTO::class)
            ->disableOriginalConstructor()->getMock();
        $this->post            = $this->getMockBuilder(Post::class)
            ->disableOriginalConstructor()->getMock();
        $this->user            = $this->getMockBuilder(User::class)
            ->disableOriginalConstructor()->getMock();

        $this->atualizarPost = new AtualizarPost($this->postRepository);
    }

    /** @test */
    public function atualizarDeveFuncionar(): void
    {
        $params = [
            'postId'   => random_int(1, 999),
            'title'    => 'Latest updates, August 1st',
            'content' => 'The whole text for the blog post goes here in this key',
            'userId' => UserId::fromInt(random_int(1, 999))
        ];

        $this->atualizaPostDto
            ->expects(self::once())
            ->method('getPostId')
            ->willReturn($params['postId']);

        $this->atualizaPostDto
            ->expects(self::once())
            ->method('getTitle')
            ->willReturn($params['title']);

        $this->atualizaPostDto
            ->expects(self::once())
            ->method('getContent')
            ->willReturn($params['content']);

        $this->atualizaPostDto
            ->expects(self::once())
            ->method('getUserId')
            ->willReturn($params['userId']);

        $this->post
            ->expects(self::once())
            ->method('user')
            ->willReturn($this->user);

        $this->user
            ->expects(self::once())
            ->method('id')
            ->willReturn($params['userId']);

        $this->postRepository
            ->expects(self::once())
            ->method('getById')
            ->with(PostId::fromInt($params['postId']))
            ->willReturn($this->post);

        $this->postRepository
            ->expects(self::once())
            ->method('store');

        $this->atualizarPost->atualizar($this->atualizaPostDto);
    }

    /** @test */
    public function atualizaDeveRetornarExceptionSeUsuarioDiferenteDoAutor(): void
    {
        $this->expectException(UserNaoAutorizadoException::class);

        $params = [
            'postId'   => random_int(1, 999),
            'userId' => UserId::fromInt(random_int(1, 999))
        ];

        $this->atualizaPostDto
            ->expects(self::once())
            ->method('getPostId')
            ->willReturn($params['postId']);

        $this->atualizaPostDto
            ->expects(self::once())
            ->method('getUserId')
            ->willReturn($params['userId']);

        $this->post
            ->expects(self::once())
            ->method('user')
            ->willReturn($this->user);

        $this->user
            ->expects(self::once())
            ->method('id')
            ->willReturn(UserId::fromInt(random_int(1000, 9999)));

        $this->postRepository
            ->expects(self::once())
            ->method('getById')
            ->with(PostId::fromInt($params['postId']))
            ->willReturn($this->post);

        $this->atualizarPost->atualizar($this->atualizaPostDto);
    }
}