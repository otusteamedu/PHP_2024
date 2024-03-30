<?php

declare(strict_types=1);

namespace App;

use App\Services\ElasticService\DbWorker;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class QueryBuilder
{
    public string $index;
    public DbWorker $client;

    public function __construct()
    {
        $this->index = 'otus-shop';
        $this->client = new DbWorker();
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function queryBuilder(array $searchData): array
    {
        if (!$this->client->isIndex($this->index)) {
            $data = dirname(__FILE__, 3) . "/books.json";
            $this->client->createIndex($this->index);
            $this->client->bulk($data);
        }

        $searchData['range_price'] = match ($searchData['range_price']) {
            ">" => 'gt',
            "<" => 'lt',
            ">=" => 'gte',
            "<=" => 'lte',
        };

        $params = [
            'bool' => [
                'must' => [
                    ['match' => ['title' => ['query' => $searchData['search_string'], 'fuzziness' => 'auto']]],
                    ['match' => ['category' => ['query' => $searchData['category'], 'fuzziness' => 'auto']]]
                ],
                'filter' => [
                    ['range' => ['stock.stock' => ['gte' => 0]]],
                    [
                        'range' => ['price' => [$searchData['range_price'] => $searchData['price']]],
                    ],
                ]
            ]
        ];

        return $this->client->getDocbyParams($this->index, $params);
    }
}
