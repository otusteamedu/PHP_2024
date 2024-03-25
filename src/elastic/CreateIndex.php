<?php

declare(strict_types=1);

namespace hw14\elastic;

use Elastic\Elasticsearch\ClientBuilder;

class CreateIndex implements ElasticInterface
{
    private $settings = '
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
        }
    }';

    public function exec()
    {
        $client = ClientBuilder::create()
            ->setSSLVerification(false)
            ->setHosts([getenv('ELASTIC_HOST')])
            ->setBasicAuthentication(
                getenv('ELASTIC_USERNAME'),
                getenv('ELASTIC_PASSWORD')
            )
            ->build();

        $params = [
            'index' => getenv('ELASTIC_INDEX')
        ];

        $response = $client->indices()->create($params);

        var_dump($response);
        die;

        $params = [
            'index' => getenv('ELASTIC_INDEX'),
            'body' => [
                $this->settings
            ]
        ];

        return $client->index($params);
    }
}
