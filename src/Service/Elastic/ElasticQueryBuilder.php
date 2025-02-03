<?php

namespace KRudenko\Otus\Service\Elastic;

use InvalidArgumentException;

class ElasticQueryBuilder
{
    public function buildQuery(array $criteria): array
    {
        $query = ['bool' => ['must' => []]];

        foreach ($criteria as $field => $condition) {
            $this->addCondition($query, $field, $condition);
        }

        return ['query' => $query];
    }

    private function addCondition(array &$query, string $field, $condition): void
    {
        if (is_array($condition)) {
            $this->handleComplexCondition($query, $field, $condition);
        } else {
            $query['bool']['must'][] = ['term' => [$field => $condition]];
        }
    }

    private function handleComplexCondition(array &$query, string $field, array $condition): void
    {
        foreach ($condition as $type => $value) {
            match($type) {
                'match' => $query['bool']['must'][] = [
                    'match' => [
                        $field => [
                            'query' => $value,
                            'fuzziness' => 'AUTO'
                        ]
                    ]
                ],
                'in' => $query['bool']['must'][] = [
                    'terms' => [
                        $field => (array)$value
                    ]
                ],
                'range' => $this->addRangeCondition($query, $field, $value),
                default => throw new InvalidArgumentException("Неподдерживаемый тип условия: $type")
            };
        }
    }

    private function addRangeCondition(array &$query, string $field, array $range): void
    {
        $query['bool']['must'][] = [
            'range' => [
                $field => array_map(function($v) {
                    return is_numeric($v) ? (float)$v : $v;
                }, $range)
            ]
        ];
    }
}
