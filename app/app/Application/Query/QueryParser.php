<?php

declare(strict_types=1);

namespace Rmulyukov\Hw11\Application\Query;

use Rmulyukov\Hw11\Application\Dto\QueryDto;
use Rmulyukov\Hw11\Application\Dto\QueryParamDto;

final class QueryParser
{
    public function createQuery(array $params): QueryDto
    {
        $queryParams = [];
        foreach ($params as $param) {
            $queryParams[] = match (true) {
                str_starts_with($param, '--price') => $this->getQueryParam('price', $param),
                str_starts_with($param, '--in_stock') => $this->getQueryParam('in_stock', $param),
                str_starts_with($param, '--category') => $this->getQueryParam('category', $param),
                str_starts_with($param, '--search') => $this->getQueryParam('search', $param),
                default => null
            };
        }
        return new QueryDto(...array_filter($queryParams));
    }

    private function getQueryParam(string $attribute, string $param): QueryParamDto
    {
        $value = explode('=', $param)[1];
        $operator = '=';
        if (str_starts_with($value, '>') || str_starts_with($value, '<')) {
            $operator = $value[0];
            $value = substr($value, 1);
        }
        return new QueryParamDto($attribute, $value, $operator);
    }
}
