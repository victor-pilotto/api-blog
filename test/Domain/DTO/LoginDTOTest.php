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
            'email'    => 'joao@gmail.com',
            'password' => '123456',
        ];

        $loginDto = LoginDTO::fromArray($defaultParams);

        self::assertSame($defaultParams['email'], $loginDto->getEmail());
        self::assertSame($defaultParams['password'], $loginDto->getPassword());
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
            'email'    => 'joao@gmail.com',
            'password' => '123456',
        ];

        $emailNaoEnviado = $defaultParams;
        unset($emailNaoEnviado['email']);

        $passwordNaoEnviado = $defaultParams;
        unset($passwordNaoEnviado['password']);

        $substituirValor = static function ($chave, $valor) use ($defaultParams) {
            return array_merge($defaultParams, [$chave => $valor]);
        };

        return [
            'fromArrayDeveFalharSeEmailForNull'                       => [
                'data'             => $substituirValor('email', null),
                'exceptionMessage' => '"email" is required',
            ],
            'fromArrayDeveFalharSeEmailForVazio'                      => [
                'data'             => $substituirValor('email', ''),
                'exceptionMessage' => '"email" is not allowed to be empty',
            ],
            'fromArrayDeveFalharSeEmailNaoForEnviado'                 => [
                'data'             => $emailNaoEnviado,
                'exceptionMessage' => '"email" is required',
            ],
            'fromArrayDeveFalharSePasswordForNull'                    => [
                'data'             => $substituirValor('password', null),
                'exceptionMessage' => '"password" is required',
            ],
            'fromArrayDeveFalharSePasswordForVazio'                   => [
                'data'             => $substituirValor('password', ''),
                'exceptionMessage' => '"password" is not allowed to be empty',
            ],
            'fromArrayDeveFalharSePasswordNaoForEnviado'              => [
                'data'             => $passwordNaoEnviado,
                'exceptionMessage' => '"password" is required',
            ],
        ];
    }
}
