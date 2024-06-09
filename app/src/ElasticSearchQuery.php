<?php

declare(strict_types=1);

namespace Dsergei\Hw11;

class ElasticSearchQuery
{
    public function __construct(
        private ConsoleParameters $consoleParameters,
        private ElasticsearchClient $client
    )
    {

    }

    private function build()
    {
        $query = [
            'query' => [
                'bool' => [
                    'must' => []
                ]
            ]
        ];

        if (!empty($this->consoleParameters->dto->getSearch()) || strlen($this->consoleParameters->dto->getSearch()) > 0) {
            $query['query']['bool']['must'][] = [
                'match' => [
                    'title' => [
                        'query' => $this->consoleParameters->dto->getSearch(),
                        'fuzziness' => 'AUTO',
                    ]
                ]
            ];
        }

        if ($this->consoleParameters->dto->getMinPrice() > 0) {
            $query['query']['bool']['filter'][] = [
                'range' => [
                    'price' => [
                        'gt' => $this->consoleParameters->dto->getMinPrice()
                    ]
                ]
            ];
        }

        if ($this->consoleParameters->dto->getMaxPrice() > 0) {
            $query['query']['bool']['filter'][] = [
                'range' => [
                    'price' => [
                        'lt' => $this->consoleParameters->dto->getMaxPrice()
                    ]
                ]
            ];
        }

        if (!empty($this->consoleParameters->dto->getCategory()) || strlen($this->consoleParameters->dto->getCategory()) > 0) {
            $query['query']['bool']['filter'][] = [
                'term' => [
                    'category.keyword' => $this->consoleParameters->dto->getCategory()
                ]
            ];
        }

        return $query;
    }

    public function query()
    {
        return $this->client->buildClient()->search(['index' => $this->consoleParameters->dto->getIndex(), 'body' => $this->build()])->asArray();
    }
}