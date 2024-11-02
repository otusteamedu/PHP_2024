<?php

namespace Komarov\Hw14\App;

class App
{
    public function run(): void
    {
        $db = Database::getConnection();
        $productMapper = new ProductMapper($db);
        $products = $productMapper->getAllProducts();

        foreach ($products as $product) {
            echo sprintf("ID: %s, Name: %s, Price: %s%s", $product->getId(), $product->getName(), $product->getPrice(), PHP_EOL);
        }

        $product = $productMapper->getProductById(1);

        if ($product) {
            echo sprintf("Product ID 1: %s, Price: %s%s", $product->getName(), $product->getPrice(), PHP_EOL);
        }
    }
}
