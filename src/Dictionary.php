<?php

declare(strict_types=1);

namespace hw14;

class Dictionary
{
    public const TEST = 'test';
    public const INIT = 'init';
    public const SEARCH = 'search';

    public const INDEX_SETTING = '
    {
    "settings": {
        "analysis": {
            "filter": {
                "ru_stop": {
                    "type": "stop",
                    "stopwords": "_russian_"
                },
                "ru_stemmer": {
                    "type": "stemmer",
                    "language": "russian"
                }
            },
            "analyzer": {
                "my_russian": {
                    "tokenizer": "standard",
                    "filter": [
                        "lowercase",
                        "ru_stop",
                        "ru_stemmer"
                    ]
                }
            }
        }
    },
    "mappings": {
        "properties": {
            "content": {
                "type": "text",
                "analyzer": "my_russian"
            }
        }
    }
}';
}
