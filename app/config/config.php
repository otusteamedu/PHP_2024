<?php

declare(strict_types=1);

return [
    'basePath' => __DIR__ . './../',
    'seedFile' => 'books.json',
    'elasticHost' => 'hw11-elastic:9200',
    'storageName' => 'otus-shop',
    'storageSettings' => [
        'settings' => [
            "analysis" => [
                "filter" => [
                    "ru_stop" => [
                        "type" => "stop",
                        "stopwords" => "_russian_"
                    ],
                    "ru_stemmer" => [
                        "type" => "stemmer",
                        "language" => "russian"
                    ]
                ],
                "analyzer" => [
                    "my_russian" => [
                        "tokenizer" => "standard",
                        "filter" => [
                            "lowercase",
                            "ru_stop",
                            "ru_stemmer"
                        ]
                    ]
                ]
            ]
        ],
        'mappings' => [
            'properties' => [
                'title' => [
                    'type' => 'text',
                    'analyzer' => 'my_russian'
                ],
                'sku' => ['type' => 'text'],
                'category' => ['type' => 'keyword'],
                'price' => ['type' => 'short'],
                'stock' => [
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
];
