<?php

namespace Komarov\Hw12\App;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Komarov\Hw12\Exception\AppException;
use Komarov\Hw12\Service\ElasticService;

class App {
    private ElasticService $elasticService;

    public function __construct() {
        $this->elasticService = new ElasticService();
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws AppException
     */
    public function run(): void
    {
        $criteria = [];
        $query = $_SERVER['argv'] ?? [];

        foreach ($query as $arg) {
            if (str_contains($arg, '=')) {
                list($field, $value) = explode('=', $arg, 2);

                if (in_array($field, ['title', 'sku', 'price', 'category'])) {
                    $criteria[$field] = $value;
                }
            }
        }

        if (empty($criteria)) {
            throw new AppException("Использование: php src/app.php <field1=value1> <field2=value2> ...\nПоля: title, sku, price, category \n");
        }

        $results = $this->elasticService->searchProducts($criteria);

        $this->showResult($results->asArray());
    }

    /**
     * @param array|null $data
     * @return void
     */
    private function showResult(?array $data): void
    {
        http_response_code(200);

        foreach ($data['hits']['hits'] as $hit) {
            echo "Title: {$hit['_source']['title']}\n";
            echo "Category: {$hit['_source']['category']}\n";
            echo "Price: {$hit['_source']['price']}\n";
            echo "---\n";
        }
    }
}
