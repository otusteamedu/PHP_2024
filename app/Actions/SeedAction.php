<?php

namespace App\Actions;

use App\App;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

final class SeedAction
{
    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function run(): void
    {
        $this->createIndex();
        $this->seedIndex();
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    private function createIndex(): void
    {
        if (App::$instance->elastic->client->indices()->exists(['index' => 'otus-shop'])) {
            App::$instance->elastic->client->indices()->flush(['index' => 'otus-shop']);
        } else {
            App::$instance->elastic->client->indices()->create([
                'index' => 'otus-shop',
                'body' => [
                    'settings' => [
                        'analysis' => [
                            'filter' => [
                                'stop' => [
                                    'type' => 'stop',
                                    'stopwords' => '_russian_'
                                ],
                                'stemmer' => [
                                    'type' => 'stemmer',
                                    'language' => 'russian'
                                ]
                            ],
                            'analyzer' => [
                                'russian' => [
                                    'tokenizer' => 'standard',
                                    'filter' => [
                                        'lowercase',
                                        'stop',
                                        'stemmer'
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'mappings' => [
                        'properties' => [
                            'title' => [
                                'type' => 'text'
                            ],
                            'sku' => [
                                'type' => 'keyword'
                            ],
                            'category' => [
                                'type' => 'keyword'
                            ],
                            'price' => [
                                'type' => 'integer'
                            ],
                            'stock' => [
                                'type' => 'nested',
                                'properties' => [
                                    'shop' => [
                                        'type' => 'keyword'
                                    ],
                                    'stock' => [
                                        'type' => 'integer'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
        }
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    private function seedIndex(): void
    {
        $file = fopen(__DIR__ . '/../Data/otus-shop.json', 'r');

        $data = [];

        while ($line = fgets($file)) {
            $data[] = json_decode($line, true);

            if (count($data) >= 1000) {
                App::$instance->elastic->client->bulk([
                    'body' => $data
                ]);

                $data = [];
            }
        }

        if (!empty($data)) {
            App::$instance->elastic->client->bulk([
                'body' => $data
            ]);
        }
    }
}
