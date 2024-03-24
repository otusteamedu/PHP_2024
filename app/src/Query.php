<?php

declare(strict_types=1);

namespace Lrazumov\Hw14;

class Query
{
    private array $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function getQuery(): array
    {
        $query = [
            'query' => [
                'bool' => [
                    'must' => [],
                ],
            ],
        ];
        $nested = [
            'path' => 'stock',
            'query' => [
                'bool' => [
                    'must' => [
                        [
                            'range' => [
                                'stock' => [
                                    'gte' => 1,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
        if (isset($this->options['shop'])) {
            $nested['query']['bool']['must'][] = [
                'term' => [
                    'stock.shop' => $this->options['shop'],
                ],
            ];
        }
        $query['query']['bool']['must'][] = $nested;
        if (isset($this->options['query'])) {
            $query['query']['bool']['must'][] = [
                'match' => [
                    'title' => [
                        'query' => $this->options['query'],
                        'operator' => 'and',
                        'fuzziness' => 'auto',
                    ],
                ],
            ];
        }
        if (isset($this->options['gte']) || isset($this->options['lte'])) {
            $range = [
                'range' => [
                    'price' => [],
                ],
            ];
            if (isset($this->options['gte'])) {
                $range['range']['price']['gte'] = $this->options['gte'];
            }
            if (isset($this->options['lte'])) {
                $range['range']['price']['lte'] = $this->options['lte'];
            }
            $query['query']['bool']['must'][] = $range;
        }
        if (isset($this->options['category'])) {
            $query['query']['bool']['must'][] = [
                'term' => [
                    'category' => $this->options['category'],
                ],
            ];
        }
        return $query;
    }
}
