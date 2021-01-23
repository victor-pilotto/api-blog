<?php

namespace Test\Domain\Service;

use App\Domain\DTO\CadastraUserDTO;
use App\Domain\Entity\User;
use App\Domain\Exception\UserJaExisteException;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Service\CadastrarUser;
use App\Domain\ValueObject\Email;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CadastrarUserTest extends TestCase
{
    private MockObject $userRepository;
    private MockObject $cadastraUserDto;
    private MockObject $user;
    private CadastrarUser $cadastrarUser;

    public function setUp(): void
    {
        $this->userRepository = $this->getMockForAbstractClass(UserRepositoryInterface::class);

        $this->cadastraUserDto = $this->getMockBuilder(CadastraUserDTO::class)
            ->disableOriginalConstructor()->getMock();
        $this->user            = $this->getMockBuilder(User::class)
            ->disableOriginalConstructor()->getMock();

        $this->cadastrarUser = new CadastrarUser($this->userRepository);
    }

    /** @test */
    public function cadastrarDeveFuncionar(): void
    {
        $params = [
            'displayName' => 'João Pedro',
            'email'       => 'joao@gmail.com',
            'password'    => '123456',
            'image'       => 'http://4.bp.blogspot.com/_YA50adQ-7vQ/S1gfR_6ufpI/AAAAAAAAAAk/1ErJGgRWZDg/S45/brett.png',
        ];

        $this->cadastraUserDto
            ->expects(self::once())
            ->method('getDisplayName')
            ->willReturn($params['displayName']);

        $this->cadastraUserDto
            ->expects(self::once())
            ->method('getEmail')
            ->willReturn($params['email']);

        $this->cadastraUserDto
            ->expects(self::once())
            ->method('getPassword')
            ->willReturn($params['password']);

        $this->cadastraUserDto
            ->expects(self::exactly(2))
            ->method('getImage')
            ->willReturn($params['image']);

        $this->userRepository
            ->expects(self::once())
            ->method('findByEmail')
            ->with(Email::fromString($params['email']))
            ->willReturn(null);

        $this->userRepository
            ->expects(self::once())
            ->method('store');

        $this->cadastrarUser->cadastrar($this->cadastraUserDto);
    }

    /** @test */
    public function cadastrarDeveRetornarExceptionSeEmailJaCadastrado(): void
    {
        $this->expectException(UserJaExisteException::class);

        $params = [
            'email' => 'joao@gmail.com',
        ];

        $this->cadastraUserDto
            ->expects(self::once())
            ->method('getEmail')
            ->willReturn($params['email']);

        $this->userRepository
            ->expects(self::once())
            ->method('findByEmail')
            ->with(Email::fromString($params['email']))
            ->willReturn($this->user);

        $this->cadastrarUser->cadastrar($this->cadastraUserDto);
    }
}
