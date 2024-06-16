<?php

declare(strict_types=1);

namespace AlexanderPogorelov\ElasticSearch\Service;

use AlexanderPogorelov\ElasticSearch\Config;
use AlexanderPogorelov\ElasticSearch\Dto\SearchDto;

readonly class QueryBuilder
{
    public function __construct(private SearchDto $dto, private Config $config)
    {
    }

    public function createQuery(): array
    {
        $query = $this->getQuerySkeleton();

        if (null !== $this->dto->category) {
            $query['bool']['filter'][] = ['term' => ['category' => $this->dto->category]];
        }

        if (null !== $this->dto->minPrice || null !== $this->dto->maxPrice) {
            $range = [];

            if (null !== $this->dto->minPrice) {
                $range['gte'] = $this->dto->minPrice;
            }

            if (null !== $this->dto->maxPrice) {
                $range['lt'] = $this->dto->maxPrice;
            }

            $query['bool']['filter'][] = ['range' => ['price' => $range]];
        }

        $query['bool']['filter'][] = $this->getOnStockFilter($this->dto->quantity);
        $query['bool']['should'][] = $this->getSockPrioritized($this->config->getStockBoostValue(), $this->config->getStockBoostScore());

        return $query;
    }

    public function getQuerySkeleton(): array
    {
        return [
            'bool' => [
                'must' => [
                    'match' => [
                        'title' => [
                            'query' => $this->dto->query,
                            'fuzziness' => 'auto',
                        ],
                    ],
                ],
                'filter' => [],
                'should' => [],
            ],
        ];
    }

    public function getOnStockFilter(int $quantity): array
    {
        return [
            'nested' => [
                'path' => 'stock',
                'query' => [
                    'bool' => [
                        'must' => [
                            [
                                'range' => [
                                    'stock.stock' => [
                                        'gte' => $quantity,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    private function getSockPrioritized(int $stockValue, int $stockBoost): array
    {
        return [
            'nested' => [
                'path' => 'stock',
                'query' => [
                    'bool' => [
                        'must' => [
                            [
                                'range' => [
                                    'stock.stock' => [
                                        'gte' => $stockValue,
                                        'boost' => $stockBoost,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
