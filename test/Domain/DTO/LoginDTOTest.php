<?php

namespace Test\Domain\DTO;

use App\Domain\DTO\LoginDTO;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class LoginDTOTest extends TestCase
{
    /** @test */
    public function fromArrayDeveFuncionar(): void
    {
        $defaultParams = [
            'email' => 'joao@gmail.com',
            'password' => '123456',
        ];

        $loginDTO = LoginDTO::fromArray($defaultParams);

        self::assertSame($defaultParams['email'], $loginDTO->getEmail());
        self::assertSame($defaultParams['password'], $loginDTO->getPassword());
    }

    /**
     * @test
     * @dataProvider providerDeErros
     */
    public function fromArrayDeveFalhar(array $data, string $exception): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($exception);

        LoginDTO::fromArray($data);
    }

    public function providerDeErros(): array
    {
        $defaultParams = [
            'email' => 'joao@gmail.com',
            'password' => '123456'
        ];

        $emailNaoEnviado = $defaultParams;
        unset($emailNaoEnviado['email']);

        $passwordNaoEnviado = $defaultParams;
        unset($passwordNaoEnviado['password']);

        $substituirValor = static function ($chave, $valor) use ($defaultParams) {
            return array_merge($defaultParams, [$chave => $valor]);
        };

        return [
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