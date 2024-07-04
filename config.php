<?php

declare(strict_types=1);

return [
    'elasticsearchHost' => [getenv('ELASTICSEARCH_HOST') . ':' . getenv('ELASTICSEARCH_EXTERNAL_PORT')],
    'elasticsearchIndex' => 'otus-shop',
    'elasticsearchIndexBody' => [
        'settings' => [
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
                        'tokenizer' => 'standard',
                        'filter' => ['lowercase', 'ru_stop', 'ru_stemmer']
                    ]
                ]
            ]
        ],
        'mappings' => [
            'properties' => [
                'category' => ['type' => 'keyword'],
                'price' => ['type' => 'integer'],
                'sku' => ['type' => 'keyword'],
                'stock' => [
                    'type' => 'nested',
                    'properties' => [
                        'shop' => ['type' => 'keyword'],
                        'stock' => ['type' => 'integer']
                    ]
                ],
                'title' => [
                    'type' => 'text',
                    'fields' => [
                        'keyword' => [
                            'type' => 'keyword',
                            'ignore_above' => 256
                        ]
                    ]
                ],
                'content' => [
                    'type' => 'text',
                    'analyzer' => 'my_russian'
                ]
            ]
        ]
    ],
    'book-data-file-path' => __DIR__ . '/storage/books.json'
];
