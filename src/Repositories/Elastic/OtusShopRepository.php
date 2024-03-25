<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Repositories\Elastic;

class OtusShopRepository extends AbstractElasticRepository
{
    protected function getIndexName(): string
    {
        return 'otus-shop';
    }

    protected function getCreateSettingsParams(): ?array
    {
        return [
            'analysis' => [
                'filter' => [
                    'ru_stop' => [
                        'type' => 'stop',
                        'stopwords' => '_russian_'
                    ],
                    'ru_stemmer' => [
                        'type' => 'stemmer',
                        'language' => 'russian'
                    ]
                ],
                'analyzer' => [
                    'my_russian' => [
                        'type' => 'custom',
                        'tokenizer' => 'standard',
                        'my_russian' => [
                            'filter' => ['lowercase', 'ru_stop', 'ru_stemmer']
                        ]
                    ]
                ]
            ]
        ];
    }

    protected function getCreateMappingsParams(): ?array
    {
        return [
            "properties" => [
                "sku"      => [
                    "type" => "text"
                ],
                "title"    => [
                    "type"     => "text",
                    "analyzer" => "my_russian"
                ],
                "category" => [
                    "type"     => "text",
                    "analyzer" => "my_russian"
                ],
                "price"    => [
                    "type" => "long"
                ],
                "stock"    => [
                    "type"       => "nested",
                    "properties" => [
                        "shop"  => [
                            "type"     => "text",
                            "analyzer" => "my_russian"
                        ],
                        "stock" => [
                            "type" => "long"
                        ]
                    ]
                ]
            ]
        ];
    }

    public function setSearchMaxPrice(int $price): void
    {
        $this->searchParams['query']['bool']['filter'][] = [
            'range' => [
                'price' => [
                    'lte' => $price
                ]
            ]
        ];
    }

    public function setSearchMinPrice(int $price): void
    {
        $this->searchParams['query']['bool']['filter'][] = [
            'range' => [
                'price' => [
                    'gte' => $price
                ]
            ]
        ];
    }

    public function setSearchInStock(): void
    {
        $this->searchParams['query']['bool']['filter'][] = [
            'range' => [
                'stock.stock' => [
                    'gte' => 1
                ]
            ]
        ];
    }

    public function setSearchTitle(string $value): void
    {
        $this->searchParams['query']['bool']['must'][] = [
            "match" => [
                "title" => [
                    'query' => $value,
                    'fuzziness' => 'auto',
                    'operator' => 'and'
                ]
            ]
        ];
    }
}
