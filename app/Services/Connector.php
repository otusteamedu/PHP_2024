<?php

namespace App\Services;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Helper\Iterators\SearchHitIterator;
use Elastic\Elasticsearch\Helper\Iterators\SearchResponseIterator;

class Connector
{
    public Client $client;

    /**
     * @throws AuthenticationException
     */
    public function __construct(private readonly string $index)
    {
        $env = parse_ini_file(__DIR__ . '/../../.env');

        $this->client = ClientBuilder::create()
            ->setHosts([$env['ELASTIC_HOST']]) // https!
            ->setBasicAuthentication('elastic', $env['ELASTIC_PASSWD']) // Пароль
            ->setCABundle(__DIR__ . $env['ELASTIC_CERT']) // Сертификат
            ->build();
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function createIndex(array $params): bool
    {
        $params = [
            'index' => $this->index,
            'body' => [
                ...$params
            ]
        ];

        return $this->client->indices()->create($params)->asBool();
    }

    public function bulk(string $dataPath): void
    {
        exec(
            "curl --location --insecure -u elastic:ueX7wnany_b1spv_j4Fe --request POST 'https://172.29.0.2:9200/_bulk' --header 'Content-Type: application/json' --data-binary '@{$dataPath}'"
        );
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function dropIndex(string $index): bool
    {
        return $this->client->indices()->delete(['index' => $index])->asBool();
    }

    public function search(array $params): string
    {
        $query = [
            'index' => $this->index,
            'scroll' => '5m',
            'size' => 100,
            'body' => [
                'query' => [
                    ...$params
                ],
            ]
        ];

        $pages = new SearchResponseIterator($this->client, $query);

        return $this->getResult(new SearchHitIterator($pages));
    }

    private function getResult(SearchHitIterator $hits): string
    {
        $result = '';

        foreach ($hits as $hit) {
            $source = $hit['_source'];

            $result .= str_repeat('═', 30) . PHP_EOL;
            $result .= "id: {$hit['_id']}" . PHP_EOL . "title: {$source['title']}" . PHP_EOL . "category: {$source['category']}" . PHP_EOL . "price: {$source['price']}" . PHP_EOL;
            if ($source['stock']) {
                $result .= 'На складе: ' . array_sum(array_column($source['stock'], 'stock')) . PHP_EOL;
            }

            $result .= str_repeat('═', 30) . PHP_EOL;
        }

        return $result;
    }


}