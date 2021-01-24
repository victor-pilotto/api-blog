<?php

namespace Test\Domain\DTO;

use App\Domain\DTO\BuscaPostPorFiltroDTO;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class BuscaPostPorFiltroDTOTest extends TestCase
{
    /**
     * @test
     * @dataProvider providerDeSucessos
     */
    public function fromArrayDeveFuncionar(array $data): void
    {
        $buscaPostPorFiltroDto = BuscaPostPorFiltroDTO::fromArray($data);

        self::assertSame($data['q'], $buscaPostPorFiltroDto->getQueryParams());
    }

    public function providerDeSucessos(): array
    {
        $defaultParams = [
            'q' => null,
        ];

        $substituirValor = static function ($chave, $valor) use ($defaultParams) {
            return array_merge($defaultParams, [$chave => $valor]);
        };

        return [
            'fromArrayDeveFuncionarComValorNull'  => [
                'data' => $substituirValor('q', null),
            ],
            'fromArrayDeveFuncionarComValorVazio' => [
                'data' => $substituirValor('q', ''),
            ],
            'fromArrayDeveFuncionar'              => [
                'data' => $defaultParams,
            ],
        ];
    }

    public function fromArrayDeveFuncionarValorEmBranco(): void
    {
        $defaultParams = [
            'q' => '',
        ];

        $buscaPostPorFiltroDto = BuscaPostPorFiltroDTO::fromArray($defaultParams);

        self::assertSame($defaultParams['q'], $buscaPostPorFiltroDto->getQueryParams());
    }

    /**
     * @test
     * @dataProvider providerDeErros
     */
    public function fromArrayDeveFalhar(array $data, string $exception): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($exception);

        BuscaPostPorFiltroDTO::fromArray($data);
    }

    public function providerDeErros(): array
    {
        return [
            'fromArrayDeveFalharSeEmailNaoForEnviado' => [
                'data'             => [],
                'exceptionMessage' => '"q" is required',
            ],
        ];
    }
}
