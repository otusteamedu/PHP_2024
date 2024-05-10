<?php

declare(strict_types=1);

namespace Tory495\Elasticsearch;

class App
{
    /**
     * Application run method
     * @return void
     */
    public function run(): void
    {
        $searchService = new SearchService();
        $client = $searchService->createClient();
        $result = $client->search([
            'index' => 'otus-shop',
            'body' => [
                'size' => 10_000,
                'query' => [
                    'bool' => [
                        'must' => [
                            [
                                'match' => [
                                    'title' => [
                                        'query' => 'рыцОри',
                                        'fuzziness' => 'auto'
                                    ]
                                ]
                            ]
                        ],
                        'filter' => [
                            [
                                'range' => [
                                    'price' => [
                                        'lte' => 2000
                                    ]
                                ]
                            ],
                            [
                                'range' => [
                                    'stock.stock' => [
                                        'gt' => 0
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        var_dump($result->asArray());
    }
}
