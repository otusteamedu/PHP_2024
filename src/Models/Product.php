<?php
namespace App\Models;

class Product {
    public $title;
    public $category;
    public $price;
    public $inStock;

    public function __construct(array $data) {
        $this->title = $data['title'] ?? '';
        $this->category = $data['category'] ?? '';
        $this->price = $data['price'] ?? 0;
        $this->inStock = isset($data['stock']) && $this->isInStock($data['stock']);
    }

     
    private function isInStock(array $stock): bool {
        foreach ($stock as $shop) {
            if ($shop['stock'] > 0) {
                return true;
            }
        }
        return false;
    }
}
