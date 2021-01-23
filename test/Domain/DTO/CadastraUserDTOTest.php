<?php

namespace Test\Domain\DTO;

use App\Domain\DTO\CadastraUserDTO;
use InvalidArgumentException;
use PHPStan\Testing\TestCase;

class CadastraUserDTOTest extends TestCase
{
    /** @test */
    public function fromArrayDeveFuncionar(): void
    {
        $defaultParams = [
            'displayName' => 'João Pedro',
            'email' => 'joao@gmail.com',
            'password' => '123456',
            'image' => 'http://4.bp.blogspot.com/_YA50adQ-7vQ/S1gfR_6ufpI/AAAAAAAAAAk/1ErJGgRWZDg/S45/brett.png'
        ];

        $cadastraUserDTO = CadastraUserDTO::fromArray($defaultParams);

        self::assertSame($defaultParams['displayName'], $cadastraUserDTO->getDisplayName());
        self::assertSame($defaultParams['email'], $cadastraUserDTO->getEmail());
        self::assertSame($defaultParams['password'], $cadastraUserDTO->getPassword());
        self::assertSame($defaultParams['image'], $cadastraUserDTO->getImage());
    }

    /** @test */
    public function fromArrayDeveFuncionarSemImagem(): void
    {
        $defaultParams = [
            'displayName' => 'João Pedro',
            'email' => 'joao@gmail.com',
            'password' => '123456'
        ];

        $cadastraUserDTO = CadastraUserDTO::fromArray($defaultParams);

        self::assertSame($defaultParams['displayName'], $cadastraUserDTO->getDisplayName());
        self::assertSame($defaultParams['email'], $cadastraUserDTO->getEmail());
        self::assertSame($defaultParams['password'], $cadastraUserDTO->getPassword());
        self::assertNull($cadastraUserDTO->getImage());
    }

    /**
     * @test
     * @dataProvider providerDeErros
     */
    public function fromArrayDeveFalhar(array $data, string $exception): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($exception);

        CadastraUserDTO::fromArray($data);
    }

    public function providerDeErros(): array
    {
        $defaultParams = [
            'displayName' => 'João Pedro',
            'email' => 'joao@gmail.com',
            'password' => '123456',
            'image' => 'http://4.bp.blogspot.com/_YA50adQ-7vQ/S1gfR_6ufpI/AAAAAAAAAAk/1ErJGgRWZDg/S45/brett.png'
        ];

        $displayNameNaoEnviado = $defaultParams;
        unset($displayNameNaoEnviado['displayName']);

        $emailNaoEnviado = $defaultParams;
        unset($emailNaoEnviado['email']);

        $passwordNaoEnviado = $defaultParams;
        unset($passwordNaoEnviado['password']);

        $substituirValor = static function ($chave, $valor) use ($defaultParams) {
            return array_merge($defaultParams, [$chave => $valor]);
        };

        return [
            'fromArrayDeveFalharSeDisplayNameTiverMenosDeOitoCaracteres'     => [
                'data'             => $substituirValor('displayName', '1234567'),
                'exceptionMessage' => '"displayName" length must be at least 8 characters long',
            ],
            'fromArrayDeveFalharSeDisplayNameForNull'     => [
                'data'             => $substituirValor('displayName', null),
                'exceptionMessage' => '"displayName" length must be at least 8 characters long',
            ],
            'fromArrayDeveFalharSeDisplayNameForVazio'     => [
                'data'             => $substituirValor('displayName', ''),
                'exceptionMessage' => '"displayName" length must be at least 8 characters long',
            ],
            'fromArrayDeveFalharSeDisplayNameNaoForEnviado'     => [
                'data'             => $displayNameNaoEnviado,
                'exceptionMessage' => '"displayName" length must be at least 8 characters long',
            ],
            'fromArrayDeveFalharSeEmailNaoTiverDominio'     => [
                'data'             => $substituirValor('email', 'joao@'),
                'exceptionMessage' => '"email" must be a valid email',
            ],
            'fromArrayDeveFalharSeEmailNaoTiverPrefixo'     => [
                'data'             => $substituirValor('email', '@gmail.com'),
                'exceptionMessage' => '"email" must be a valid email',
            ],
            'fromArrayDeveFalharSeEmailForNull'     => [
                'data'             => $substituirValor('email', null),
                'exceptionMessage' => '"email" is required',
            ],
            'fromArrayDeveFalharSeEmailForVazio'     => [
                'data'             => $substituirValor('email', ''),
                'exceptionMessage' => '"email" must be a valid email',
            ],
            'fromArrayDeveFalharSeEmailNaoForEnviado'     => [
                'data'             => $emailNaoEnviado,
                'exceptionMessage' => '"email" is required',
            ],
            'fromArrayDeveFalharSePasswordTiverMenosDeSeisCaracteres'     => [
                'data'             => $substituirValor('password', '12345'),
                'exceptionMessage' => '"password" length must be at least 6 characters long',
            ],
            'fromArrayDeveFalharSePasswordForNull'     => [
                'data'             => $substituirValor('password', null),
                'exceptionMessage' => '"password" is required',
            ],
            'fromArrayDeveFalharSePasswordForVazio'     => [
                'data'             => $substituirValor('password', ''),
                'exceptionMessage' => '"password" length must be at least 6 characters long',
            ],
            'fromArrayDeveFalharSePasswordNaoForEnviado'     => [
                'data'             => $passwordNaoEnviado,
                'exceptionMessage' => '"password" is required',
            ]
        ];
    }
}