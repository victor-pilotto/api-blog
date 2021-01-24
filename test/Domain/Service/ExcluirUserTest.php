<?php

namespace Test\Domain\Service;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Service\ExcluirUser;
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

        $this->user = $this->getMockBuilder(User::class)
            ->disableOriginalConstructor()->getMock();

        $this->excluirUser = new ExcluirUser($this->userRepository);
    }

    /** @test */
    public function excluirDeveFuncionar(): void
    {
        $this->userRepository
            ->expects(self::once())
            ->method('remove');

        $this->excluirUser->excluir($this->user);
    }
}
