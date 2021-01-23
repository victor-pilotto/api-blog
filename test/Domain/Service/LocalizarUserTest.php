<?php

namespace Test\Domain\Service;

use App\Domain\DTO\LoginDTO;
use App\Domain\Entity\User;
use App\Domain\Exception\LoginComCamposInvalidosException;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Service\LocalizarUser;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Password;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class LocalizarUserTest extends TestCase
{
    private MockObject $userRepository;
    private MockObject $loginDto;
    private MockObject $user;
    private LocalizarUser $localizarUser;

    public function setUp(): void
    {
        $this->userRepository = $this->getMockForAbstractClass(UserRepositoryInterface::class);

        $this->loginDto = $this->getMockBuilder(LoginDTO::class)
            ->disableOriginalConstructor()->getMock();
        $this->user     = $this->getMockBuilder(User::class)
            ->disableOriginalConstructor()->getMock();

        $this->localizarUser = new LocalizarUser($this->userRepository);
    }

    /** @test */
    public function localizarDeveFuncionar(): void
    {
        $params = [
            'email'    => 'joao@gmail.com',
            'password' => '123456',
        ];

        $this->loginDto
            ->expects(self::once())
            ->method('getEmail')
            ->willReturn($params['email']);

        $this->loginDto
            ->expects(self::once())
            ->method('getPassword')
            ->willReturn($params['password']);

        $this->userRepository
            ->expects(self::once())
            ->method('findByEmailAndPassword')
            ->with(Email::fromString($params['email']), Password::fromString($params['password']))
            ->willReturn($this->user);

        $this->localizarUser->localizar($this->loginDto);
    }

    /** @test */
    public function localizarDeveRetornarExceptionSeNaoEncontrarUser(): void
    {
        $this->expectException(LoginComCamposInvalidosException::class);

        $params = [
            'email'    => 'joao@gmail.com',
            'password' => '123456',
        ];

        $this->loginDto
            ->expects(self::once())
            ->method('getEmail')
            ->willReturn($params['email']);

        $this->loginDto
            ->expects(self::once())
            ->method('getPassword')
            ->willReturn($params['password']);

        $this->userRepository
            ->expects(self::once())
            ->method('findByEmailAndPassword')
            ->with(Email::fromString($params['email']), Password::fromString($params['password']))
            ->willReturn(null);

        $this->localizarUser->localizar($this->loginDto);
    }
}
