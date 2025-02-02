<?php

namespace KRudenko\Otus\Service\Elastic;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use RuntimeException;

class ElasticQueryBuilder
{
    private array $query = ['bool' => ['must' => [], 'filter' => []]];
    private int $from = 0;

    public function __construct(private readonly Client $client) {}

    public function matchText(string $field, string $value): self
    {
        if (!empty($value)) {
            $this->query['bool']['must'][] = [
                'match' => [
                    $field => [
                        'query' => $value,
                        'fuzziness' => 'AUTO'
                    ]
                ]
            ];
        }
        return $this;
    }

    public function filterRange(string $field, array $conditions): self
    {
        $range = [];
        foreach ($conditions as $condition) {
            $operator = $condition['operator'];
            $value = $condition['value'];
            $range[$operator] = $value;
        }

        if (!empty($range)) {
            $this->query['bool']['filter'][] = [
                'range' => [
                    $field => $range
                ]
            ];
        }
        return $this;
    }

    public function paginate(int $page): self
    {
        $this->from = ($page - 1) * $_ENV['PAGE_SIZE'];

        return $this;
    }

    public function build(): array
    {
        return [
            'index' => $_ENV['ELASTIC_INDEX'],
            'body'  => ['query' => $this->query],
            'from'  => $this->from,
            'size'  => $_ENV['PAGE_SIZE'],
        ];
    }

    public function execute(): array
    {
        try {
            $response = $this->client->search($this->build());
            return $response->asArray();
        } catch (ClientResponseException|ServerResponseException $e) {
            throw new RuntimeException('Search failed: '.$e->getMessage());
        }
    }

    public static function parsePriceConditions(array $prices): array
    {
        $conditions = [];
        $operatorsMap = [
            '=' => 'eq',
            '>' => 'gt',
            '<' => 'lt',
            '>=' => 'gte',
            '<=' => 'lte'
        ];

        foreach ($prices as $price) {
            preg_match('/([<>=]{0,2})(\d+)/', $price, $matches);
            $operator = $matches[1] ?: '=';
            $value = (float)$matches[2];

            $conditions[] = [
                'operator' => $operatorsMap[$operator],
                'value' => $value
            ];
            if (count($conditions) === 2) {
                break;
            }
        }

        return $conditions;
    }
}
