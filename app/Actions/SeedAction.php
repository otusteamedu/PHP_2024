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
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    private function createIndex(): void
    {
        if (App::$instance->elastic->client->indices()->exists(['index' => 'otus-shop'])) {
            App::$instance->elastic->client->indices()->delete(['index' => 'otus-shop']);
        }

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