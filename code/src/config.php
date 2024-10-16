<?php

return [
    'elastic' => [
        'host' =>  getenv('ELASTIC_HOST') ? getenv('ELASTIC_HOST') : 'elastic:9200',
        'index' => getenv('ELASTIC_INDEX') ? getenv('ELASTIC_INDEX') : 'otus-shop',
        "mappings" => [
            "properties" => [
                "category" => [
                    "type" => "keyword"
                ],
                "price" => [
                    "type" => "integer"
                ],
                "sku" => [
                    "type" => "keyword"
                ],
                "stock" => [
                    "type" => "nested",
                    "properties" => [
                        "shop" => [
                            "type" => "keyword"
                        ],
                        "stock" => [
                            "type" => "integer"
                        ]
                    ]
                ],
                "title" => [
                    "type" => "text",
                    "fields" => [
                        "keyword" => [
                            "type" => "keyword",
                            "ignore_above" => 256
                        ]
                    ]
                ],
                "content" => [
                    "type" => "text",
                    "analyzer" => "my_russian"
                ]

            ]
        ],
        "settings" => [
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
        ]
    ]

];
