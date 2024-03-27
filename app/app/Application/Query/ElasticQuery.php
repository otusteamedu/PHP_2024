<?php

declare(strict_types=1);

namespace Rmulyukov\Hw11\Application\Query;

use Rmulyukov\Hw11\Application\Dto\QueryDto;
use Rmulyukov\Hw11\Application\Dto\QueryParamDto;

final class ElasticQuery
{
    public function prepare(QueryDto $query): array
    {
        $body = [
            'query' => [
                'bool' => [
                    'must' => [
                        'match' => []
                    ],
                    'filter' => []
                ]
            ]
        ];

        foreach ($query->getParams() as $param) {
            switch ($param->getAttribute()) {
                case 'search':
                    $body['query']['bool']['must']['match'] = $this->prepareTitle($param);
                    break;
                case 'in_stock':
                    $body['query']['bool']['filter'][] = $this->prepareStock($param);
                    break;
                default:
                    $body['query']['bool']['filter'][] = $param->getOperation() === 'term' ?
                        $this->prepareTerm($param->getAttribute(), $param) :
                        $this->prepareRange($param->getAttribute(), $param->getOperator(), $param->getValue());
            }
        }

        return $body;
    }

    private function prepareTitle(QueryParamDto $param): array
    {
        return [
            'title' => [
                'query' => $param->getValue(),
                'fuzziness' => 'auto'
            ]
        ];
    }

    private function prepareStock(QueryParamDto $param): array
    {
        $operator = $param->getValue() === 'true' ? 'gt' : 'gte';
        return $this->prepareRange('stock.stock', $operator, 0);
    }

    private function prepareTerm(string $attribute, QueryParamDto $param): array
    {
        return [
            'term' => [
                $attribute => $param->getValue()
            ]
        ];
    }

    private function prepareRange(string $attribute, string $operator, mixed $value): array
    {
        return [
            'range' => [
                $attribute => [
                    $operator => $value
                ]
            ]
        ];
    }
}
