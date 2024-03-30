<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\Infrastructure\Repository\Elastic;

use Rmulyukov\Hw\Application\Event\Criteria;

final class Query
{
    public function prepare(Criteria ...$criteria): array
    {
        $res = [
            'from' => 0,
            'size' => 1,
            'query' => [
                'bool' => [
                    'must' => []
                ]
            ],
            'sort' => [
                'priority' => [
                    'order' => 'desc'
                ]
            ]
        ];

        foreach ($criteria as $criterion) {
            $res['query']['bool']['must'][] = [
                'term' => [
                    $criterion->getName() => $criterion->getValue()
                ]
            ];
        }

        return $res;
    }
}
