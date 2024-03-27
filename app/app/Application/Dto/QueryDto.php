<?php

declare(strict_types=1);

namespace Rmulyukov\Hw11\Application\Dto;

final readonly class QueryDto
{
    /** @var QueryParamDto[] */
    private array $params;

    public function __construct(QueryParamDto ...$params)
    {
        $this->params = $params;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
