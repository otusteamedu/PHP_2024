<?php

namespace VladimirGrinko\ElasticSearch;

class Build
{
    private $params = [];

    public function __construct(
        string $name,
        string $category,
        ?float $priceBot = null,
        ?float $priceTop = null,
        string $shop = '',
        ?int $stock = null
    ) {
        $this->params['bool']['must'] = $this->buildMust($name, $category);
        $this->params['bool']['filter'] = $this->buildPrice($priceBot, $priceTop);
        $this->params['bool']['filter'] = $this->buildStock($shop, $stock);
    }

    public function getParams(): array
    {
        return $this->params;
    }

    private function buildStock(string $shop, ?int $stock): array
    {
        $params = [];
        if (!empty(trim($shop)) && $stock >= 0) {
            $params['nested'] = [
                'path' => 'stock',
                'query' => [
                    'bool' => [
                        'filter' => [
                            [
                                'match' => [
                                    'stock.shop' => [
                                        'query' => $shop
                                    ]
                                ]
                            ],
                            [
                                'range' => [
                                    'stock.stock' => [
                                        'gte' => $stock
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ];
        }
        return $params;
    }

    private function buildPrice(?float $priceBot, ?float $priceTop): array
    {
        $params = [];
        if ($priceBot !== null) {
            $params['range']['price']['gte'] = $priceBot;
        }
        if ($priceTop !== null) {
            $params['range']['price']['lt'] = $priceTop;
        }
        return $params;
    }

    private function buildMust(string $name, string $category): array
    {
        $params = [];
        if (!empty(trim($name))) {
            $params[] = $this->buildName($name);
        }
        if (!empty(trim($category))) {
            $params[] = $this->buildCategory($category);
        }
        return $params;
    }

    private function buildName(string $name): array
    {
        return [
            "match" => [
                "title" => [
                    "query" => $name,
                    "fuzziness" => "auto"
                ]
            ]
        ];
    }

    private function buildCategory(string $category): array
    {
        return [
            "match" => [
                "category" => [
                    "query" => $category
                ]
            ]
        ];
    }
}
