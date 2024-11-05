<?php
namespace App\Infrastructure\Persistence;

use App\Domain\Model\Product;
use App\Domain\Repository\ProductRepository;
use Elasticsearch\ClientBuilder;

class ElasticSearchProductRepository implements ProductRepository {
    private $client;
    private string $index;

    public function __construct(array $config) {
        $this->client = ClientBuilder::create()->setHosts($config['hosts'])->build();
        $this->index = $config['index'];
    }

    public function search(string $query, ?float $maxPrice = null): array {
        $params = [
            'index' => $this->index,
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [
                            [
                                'multi_match' => [
                                    'query' => $query,
                                    'fields' => ['title', 'category'],
                                    'fuzziness' => 'AUTO',
                                ]
                            ]
                        ],
                        'filter' => [
                            ['term' => ['in_stock' => true]]
                        ]
                    ]
                ],
                'sort' => ['_score' => 'desc']
            ]
        ];

        if ($maxPrice !== null) {
            $params['body']['query']['bool']['filter'][] = [
                'range' => ['price' => ['lte' => $maxPrice]]
            ];
        }

        $response = $this->client->search($params);
        $products = [];

        foreach ($response['hits']['hits'] as $hit) {
            $data = $hit['_source'];
            $products[] = new Product(
                $data['title'],
                $data['category'],
                $data['price'],
                $data['in_stock']
            );
        }

        return $products;
    }
}
