<?php

namespace Test\Domain\Service;

use App\Domain\Entity\User;
use App\Domain\Exception\UserNaoExisteException;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Service\ExcluirUser;
use App\Domain\ValueObject\UserId;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ExcluirUserTest extends TestCase
{
    private MockObject $userRepository;
    private MockObject $user;
    private ExcluirUser $excluirUser;

    public function setUp(): void
    {
        $this->userRepository = $this->getMockForAbstractClass(UserRepositoryInterface::class);

        $this->user            = $this->getMockBuilder(User::class)
            ->disableOriginalConstructor()->getMock();

        $this->excluirUser = new ExcluirUser($this->userRepository);
    }

    /** @test */
    public function excluirDeveFuncionar(): void
    {
        $this->userRepository
            ->expects(self::once())
            ->method('getById')
            ->willReturn($this->user);

        $this->userRepository
            ->expects(self::once())
            ->method('remove');

        $this->excluirUser->excluir(UserId::fromInt(random_int(1, 999)));
    }

    /** @test */
    public function excluirDeveRetornarExceptionSeNaoEncontrarUser(): void
    {
        $this->expectException(UserNaoExisteException::class);

        $this->userRepository
            ->expects(self::once())
            ->method('getById')
            ->willThrowException(new UserNaoExisteException());

        $this->excluirUser->excluir(UserId::fromInt(random_int(1, 999)));
    }
}