<?php

namespace App\Domain\DTO;

use Assert\Assertion;

class BuscaPostPorFiltroDTO
{
    private function __construct(
        private ?string $queryParams
    ) {
    }

    public function getQueryParams(): ?string
    {
        return $this->queryParams;
    }

    public static function fromArray(array $params): self
    {
        Assertion::nullOrKeyExists($params, 'q', '"q" is required');

        return new self(
            $params['q']
        );
    }
}