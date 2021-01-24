<?php

namespace Test\Domain\DTO;

use App\Domain\DTO\ExcluiPostDTO;
use App\Domain\Entity\User;
use InvalidArgumentException;
use PHPStan\Testing\TestCase;

class ExcluiPostDTOTest extends TestCase
{
    /** @test */
    public function fromArrayDeveFuncionar(): void
    {
        $params = [
            'postId' => random_int(1, 999),
            'user'   => $this->getMockBuilder(User::class)->disableOriginalConstructor()->getMock(),
        ];

        $excluiDtoTest = ExcluiPostDTO::fromArray($params);

        self::assertSame($params['postId'], $excluiDtoTest->getPostId());
        self::assertSame($params['user'], $excluiDtoTest->getUser());
    }

    /** @test */
    public function fromArrayDeveRetornaExceptionSePostIdDeTipoErrado(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $params = ['postId' => 'string'];

        ExcluiPostDTO::fromArray($params);
    }
}
