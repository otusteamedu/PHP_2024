<?php

namespace Otus\App\Elastic;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use InvalidArgumentException;

class Finder
{
    public Client $client;
    public Config $config;

    public array $searchQuery;

    public function __construct($elastic)
    {
        $this->client = $elastic->client;
        $this->config = $elastic->config;

        $this->searchQuery = [
            'index' => $this->config->indexName,
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => []
                    ]
                ]
            ]
        ];
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function findAll()
    {
        $searchParams = $this->config->searchParams;

        foreach ($searchParams as $key => $value) {
            switch (true) {
                case is_array($value):
                    $this->processRangeParameter($key, $value);
                    break;
                default:
                    $this->searchQuery['body']['query']['bool']['must'][] = [
                        'match' => [
                            $key => [
                                'query' => $value,
                                'fuzziness' => 'AUTO'
                            ]
                        ]
                    ];
            }
        }

        $found = $this->client->search($this->searchQuery)->asArray();
        return $found['hits']['hits'];
    }

    /**
     * Обработка range параметров
     * @param string $paramName
     * @param array $parts
     * @return void
     */
    private function processRangeParameter(string $paramName, array $parts): void
    {
        $gte = $parts[0];
        $lte = $parts[1];

        if (!$paramName) {
            throw new InvalidArgumentException(
                "Parameter name can't be empty!" . PHP_EOL .
                'Please check the documentation!'
            );
        }

        if (!$lte && !$gte) {
            throw new InvalidArgumentException(
                "Both lte and gte params can't be empty simultaneously!" . PHP_EOL .
                'Please check the documentation!'
            );
        }

        $rangeQuery = [];

        if ($gte) {
            $rangeQuery['gte'] = $gte;
        }

        if ($lte) {
            $rangeQuery['lte'] = $lte;
        }

        $this->searchQuery['body']['query']['bool']['must'][] = [
            'range' => [
                $paramName => $rangeQuery
            ]
        ];
    }
}
