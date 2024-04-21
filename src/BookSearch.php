<?php

declare(strict_types=1);

namespace AShutov\Hw14;

use Elastic\Elasticsearch\Helper\Iterators\SearchHitIterator;
use Exception;

class BookSearch implements SearchInterface
{
    public ElasticHandler $client;
    public string $query;
    public string $category;
    public string $priceFrom;
    public string $priceTo;

    public function __construct(ElasticHandler $client)
    {
        $this->client = $client;
    }

    public function fields(): array
    {
        return [
            'query' => 'Введите название книги: ',
            'category' => 'Введите жанр: ',
            'priceFrom' => 'Стоимость от: ',
            'priceTo' => 'Стоимость до: ',
        ];
    }

    /**
     * @throws Exception
     */
    public function search(): string
    {
        $must = [];
        $filter = [];

        if (!empty($this->category)) {
            $must[] = ['term' => ['category.keyword' => $this->category]];
        }

        if (!empty($this->priceFrom)) {
            $filter[] = ['range' => ['price' => ['gte' => (int) $this->priceFrom]]];
        }

        if (!empty($this->priceTo)) {
            $filter[] = ['range' => ['price' => ['lt' => (int) $this->priceTo]]];
        }

        $query = [
            'index' => $this->client->config->elasticIndex,
            'scroll' => '5m',
            'size' => 100,
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [
                            ['match' => ['title' => ['query' => $this->query, 'fuzziness' => 'auto']]],
                            ...$must
                        ],
                        'filter' => [
                            ['range' => ['stock.stock' => ['gte' => 0]]],
                            ...$filter
                        ]
                    ]
                ],
            ]
        ];

        $hits = $this->client->search($query);

        return $this->getResult($hits);
    }

    private function getResult(SearchHitIterator $hits): string
    {
        $result = '';

        foreach ($hits as $hit) {
            $source = $hit['_source'];

            $result .= "id: {$hit['_id']}" . PHP_EOL
                . "Название: {$source['title']}" . PHP_EOL
                . "Жанр: {$source['category']}" . PHP_EOL
                . "Стоимость: {$source['price']} руб." . PHP_EOL;

            if ($source['stock']) {
                $result .= 'На складах: ' . array_sum(
                    array_column($source['stock'], 'stock')
                ) . ' шт.' . PHP_EOL;
            }
            $result .= '-----------' . PHP_EOL;
        }

        if (empty($result)) {
            $result = 'Ничего не нашли :(' . PHP_EOL;
        }

        return $result;
    }
}
