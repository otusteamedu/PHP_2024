<?php
namespace App\Console;

use App\Data\ProductRepository;

class SearchCommand {
    private $repository;

    public function __construct(ProductRepository $repository) {
        $this->repository = $repository;
    }

    public function execute($args) {
        $query = $args[1] ?? '';
        $maxPrice = $args[2] ?? null;

        $results = $this->repository->searchProducts($query, $maxPrice);

        if ($results['hits']['total']['value'] > 0) {
            echo "Результаты поиска:\n";
            echo str_pad("Название", 20) . str_pad("Категория", 15) . "Цена\n";
            foreach ($results['hits']['hits'] as $hit) {
                $product = $hit['_source'];
                echo str_pad($product['title'], 20) . str_pad($product['category'], 15) . "{$product['price']}\n";
            }
        } else {
            echo "Нет товаров по запросу.\n";
        }
    }
}
