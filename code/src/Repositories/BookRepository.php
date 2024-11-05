<?php

namespace Naimushina\ElasticSearch\Repositories;

class BookRepository implements RepositoryInterface
{
    /**
     * @inheritDoc
     * @param array $params
     * @return array
     */
    public function formatSearchParams(array $params): array
    {
        $elasticSearchParams = [];
        $searchParams = [];
        foreach ($params as $name => $value) {
            switch ($name) {
                case 'title':
                    $searchParams['filter'][] =
                        [
                            'match' =>
                                [
                                    'title' =>
                                        [
                                            'query' => $value,
                                            "fuzziness" => "auto"
                                        ]
                                ]
                        ];
                    break;
                case 'category':
                    $searchParams['must']['term'] = [
                        'category' => $value
                    ];
                    break;
                case 'price':
                    $minPrice = $value['min'] ?? 0;
                    $maxPrice = $value['max'] ?? 0;
                    if ($minPrice) {
                        $searchParams['filter'][] = [
                            'range' => [
                                'price' => [
                                    'gte' => $value['min']
                                ]
                            ]
                        ];
                    }
                    if ($maxPrice) {
                        $searchParams['filter'][] = [
                            'range' => [
                                'price' => [
                                    'lte' => $value['max']
                                ]
                            ]
                        ];
                    }
                    break;
            }
        }
        $elasticSearchParams['query']['bool'] = $searchParams;
        $elasticSearchParams['sort']['price']['order'] = "desc";
        $elasticSearchParams['query']['bool']['should']['nested']['path'] = 'stock';
        $elasticSearchParams['query']['bool']['should']['nested']['query']['range'] = ['stock.stock' => ['gte' => 15]];


        return $elasticSearchParams;
    }
}
