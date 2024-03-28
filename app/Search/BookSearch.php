<?php

declare(strict_types=1);

namespace App\Search;

use App\Contracts\ConnectorInterface;
use App\Contracts\SearchInterface;
use Elastic\Elasticsearch\Helper\Iterators\SearchHitIterator;

class BookSearch implements SearchInterface
{
    private const INDEX = 'otus-shop';

    public string $query;
    public string $category;
    public string $priceFrom;
    public string $priceTo;

    public function __construct(private readonly ConnectorInterface $client)
    {
    }

    public function fields(): array
    {
        return [
            'query' => 'Поиск: ',
            'category' => 'Категория: ',
            'priceFrom' => 'Цена от: ',
            'priceTo' => 'Цена до: ',
        ];
    }

    public function search(): string
    {
        $must = [];
        $filter = [];

        if (!empty($this->category)) {
            $must[] = ['term' => ['category.keyword' => $this->category]];
        }

        if (!empty($this->priceFrom)) {
            $filter[] = ['range' => ['price' => ['gte' => (int)$this->priceFrom]]];
        }

        if (!empty($this->priceTo)) {
            $filter[] = ['range' => ['price' => ['lt' => (int)$this->priceTo]]];
        }

        $query = [
            'index' => self::INDEX,
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

            $result .= str_repeat('═', 30) . PHP_EOL;
            $result .= "id: {$hit['_id']}"
                . PHP_EOL
                . "title: {$source['title']}"
                . PHP_EOL . "category: {$source['category']}"
                . PHP_EOL
                . "price: {$source['price']}"
                . PHP_EOL;

            if ($source['stock']) {
                $result .= 'На складе: ' . array_sum(
                        array_column($source['stock'], 'stock')
                    ) . PHP_EOL;
            }

            $result .= str_repeat('═', 30) . PHP_EOL;
        }

        return $result;
    }
}
