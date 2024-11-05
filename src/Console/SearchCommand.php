<?php
namespace App\Console;

use App\Application\Service\ProductSearchService;

class SearchCommand {
    private ProductSearchService $searchService;

    public function __construct(ProductSearchService $searchService) {
        $this->searchService = $searchService;
    }

    public function execute(array $args) {
        $query = $args[1] ?? '';
        $maxPrice = isset($args[2]) ? (float)$args[2] : null;

        $results = $this->searchService->search($query, $maxPrice);

        if (count($results) > 0) {
            echo str_pad("Название", 30) . str_pad("Категория", 20) . "Цена\n";
            echo str_repeat("-", 60) . "\n";

            foreach ($results as $product) {
                echo str_pad($product->getTitle(), 30) .
                     str_pad($product->getCategory(), 20) .
                     number_format($product->getPrice(), 2) . "\n";
            }
        } else {
            echo "Нет товаров по запросу.\n";
        }
    }
}
