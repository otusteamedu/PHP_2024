<?php

namespace VladimirGrinko\Seeker\ElasticSearch;

class Build
{
    private $params = [];

    private string $name = '';
    private string $category = '';
    private ?float $priceBot = null;
    private ?float $priceTop = null;
    private string $shop = '';
    private ?int $stock = null;

    public function __construct()
    {
    }

    public function getParams(): array
    {
        $this->params['bool']['must'] = $this->buildMust($this->name, $this->category);
        if (!empty($arPrice = $this->buildPrice($this->priceBot, $this->priceTop))) {
            $this->params['bool']['filter'] = $arPrice;
        }
        if (!empty($arStock = $this->buildStock($this->shop, $this->stock))) {
            $this->params['bool']['filter'] = $arStock;
        }
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

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    public function setPriceBot(float $priceBot): void
    {
        $this->priceBot = $priceBot;
    }

    public function setPriceTop(float $priceTop): void
    {
        $this->priceTop = $priceTop;
    }

    public function setShop(string $shop): void
    {
        $this->shop = $shop;
    }

    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }
}
