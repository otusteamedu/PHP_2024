<?php

return [
    'elasticsearch' => [
        'indexSettings' => [
            'analysis' => [
                'filter' => [
                    'ru_stop' => [
                        'type' => 'stop',
                        'stopwords' => '_russian_',
                    ],
                    'ru_stemmer' => [
                        'type' => 'stemmer',
                        'language' => 'russian',
                    ],
                ],
                'analyzer' => [
                    'my_russian' => [
                        'tokenizer' => 'standard',
                        'filter' => [
                            'lowercase',
                            'ru_stop',
                            'ru_stemmer'
                        ]
                    ]
                ]
            ],
        ],
        'logPath' => __DIR__ . '/../logs/host_metrics_app.log'
    ],
];
