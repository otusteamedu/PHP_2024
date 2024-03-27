<?php

declare(strict_types=1);

namespace Hukimato\EsApp;

class QueryBuilder
{
    protected ?int $minPrice;
    protected ?int $maxPrice;
    protected ?string $title;
    protected ?string $category;


    public function __construct($minPrice = null, $maxPrice = null, $title = null, $category = null)
    {
        $this->minPrice = $minPrice;
        $this->maxPrice = $maxPrice;
        $this->title = $title;
        $this->category = $category;
    }

    public function getQuery()
    {
        $default = [
            'index' => 'otus-shop',
            'body' => [
                "query" => [
                    "bool" => [
                        "must" => [
//                            [
//                                "match" => [
//                                    "title" => [
//                                        "query" => "Похождения Довакина за границей",
//                                        "fuzziness" => "auto"
//                                    ]
//                                ]
//                            ]
                        ],
                        "filter" => [
//                            [
//                                "range" => [
//                                    "price" => [
//                                        "lt" => 3000,
//                                        "gt" => 2000
//                                    ]
//                                ]
//                            ],
//                            [
//                                "term" => [
//                                    "category" => "Детская литература"
//                                ]
//                            ],
                            [
                                "nested" => [
                                    "path" => "stock",
                                    "query" => [
                                        "bool" => [
                                            "filter" => [
                                                [
                                                    "range" => [
                                                        "stock.stock" => [
                                                            "gt" => 0
                                                        ]
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        "should" => [
                            [
                                "nested" => [
                                    "path" => "stock",
                                    "score_mode" => "sum",
                                    "query" => [
                                        "bool" => [
                                            "must" => [
                                                [
                                                    "range" => [
                                                        "stock.stock" => [
                                                            "gte" => 10
                                                        ]
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        if (!is_null($this->minPrice) || !is_null($this->maxPrice)) {
            $default['body']['query']['bool']['filter'][] = $this->createPriceQuery();
        }
        if ($this->title) {
            $default['body']['query']['bool']['must'][] = $this->createTitleQuery();
        }
        if ($this->category) {
            $default['body']['query']['bool']['filter'][] = $this->createCategoryQuery();
        }

        return $default;
    }

    protected function createTitleQuery(): array|null
    {
        return [
            'match' => [
                'title' => [
                    'query' => $this->title,
                    'fuzziness' => 'auto'
                ]
            ]
        ];
    }

    protected function createCategoryQuery(): array|null
    {
        return [
            'term' => [
                'category' => $this->category
            ]
        ];
    }

    protected function createPriceQuery(): array|null
    {
        $default = [
            "range" => [
                "price" => [
                ]
            ]
        ];

        if (!is_null($this->minPrice)) {
            $default['range']['price']['gte'] = $this->minPrice;
        }

        if (!is_null($this->maxPrice)) {
            $default['range']['price']['lte'] = $this->maxPrice;
        }

        return $default;
    }
}
