<?php

declare(strict_types=1);

namespace Viking311\Books\Search;

class QueryBuilder
{
    private readonly string $indexName;

    /**
     * @param string $indexName
     */
    public function __construct(string $indexName)
    {
        $this->indexName = $indexName;
    }


    /**
     * @param array $options
     * @return array
     */
    public function createRequest(array $options): array
    {
        $query = [];

        if (array_key_exists('c', $options)) {
            $query['bool']['must']['match']['title'] = [
                'query' => $options['c'],
                'fuzziness' => 'auto',
            ];
        }

        if (array_key_exists('l', $options)) {
            $query['bool']['filter']['range']['price']['lt'] = (float)$options['l'];
        }

        if (array_key_exists('g', $options)) {
            $query['bool']['filter']['range']['price']['gt'] = (float)$options['g'];
        }

        if (array_key_exists('e', $options)) {
            $query['bool']['filter']['range']['price']['gte'] = (float)$options['e'];
            $query['bool']['filter']['range']['price']['lte'] = (float)$options['e'];
        }

        return [
            'index' => $this->indexName,
            'body' => [
                'query' => $query,
            ],
        ];
    }
}
