<?php

return [
    'elasticsearch' => [
        'settings' => [
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
        ]
    ]
];
