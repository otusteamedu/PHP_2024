<?php

namespace Otus\App\Elastic;

class Query
{
    public \Elastic\Elasticsearch\Client $client;
    public Config $config;

    public function __construct($elastic)
    {
        $this->client = $elastic->client;
        $this->config = $elastic->config;
    }

    public function findAll()
    {
        $params = [
            'index' => $this->config->indexName,
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => []
                    ]
                ]
            ]
        ];

        // price_min | price_max
        if (isset($this->config->searchParams['price_min']) || isset($this->config->searchParams['price_max'])) {
            $rangeQuery = [];

            if (isset($this->config->searchParams['price_min'])) {
                $rangeQuery['gte'] = $this->config->searchParams['price_min'];
            }

            if (isset($this->config->searchParams['price_max'])) {
                $rangeQuery['lte'] = $this->config->searchParams['price_max'];
            }

            $params['body']['query']['bool']['must'][] = [
                'range' => [
                    'price' => $rangeQuery
                ]
            ];
        }

        // Rest
        foreach ($this->config->searchParams as $key => $value) {
            if ($key !== 'price_min' && $key !== 'price_max') {
                $params['body']['query']['bool']['must'][] = [
                    'match' => [
                        $key => [
                            'query' => $value,
                            'fuzziness' => 'AUTO'
                        ]
                    ]
                ];
            }
        }

        $found = $this->client->search($params)->asArray();
        return $found['hits']['hits'];
    }
}
