<?php
namespace App\Data;

class ProductRepository {
    private $client;

    public function __construct(ElasticSearchClient $client) {
        $this->client = $client;
    }

    public function initializeData($filePath) {
        $products = json_decode(file_get_contents($filePath), true);
        foreach ($products as $product) {
            $this->client->indexProduct($product);
        }
    }

    public function searchProducts($query, $maxPrice = null) {
        $params = [
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
                        ['term' => ['in_stock' => true]],
                    ]
                ]
            ],
            'sort' => ['_score' => 'desc']
        ];

        if ($maxPrice !== null) {
            $params['query']['bool']['filter'][] = ['range' => ['price' => ['lte' => $maxPrice]]];
        }

        return $this->client->search($params);
    }
}
