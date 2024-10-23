<?php

namespace App\Domain\Service;

use App\Controller\Enum\ServiceMessage;
use App\Domain\Entity\Product;

class ProductServiceAdapter
{
    private ProductService $service;

    public function __construct()
    {
        $this->service = new ProductService();
    }

    public function findById(string $json): string
    {
        $product = $this->service->findById($this->jsonToArray($json)['id']);

        if ($product) {
            $product = $this->getJsonFromProductObject($product);
        }

        return "\nПродукт найден: $product" ?: ServiceMessage::ProductFindError->value;
    }

    public function findByCriteria(string $json): string
    {
        $criteria = $this->jsonToArray($json);
        $productArray  = $this->service->findByCriteria($criteria);

        if ($productArray) {
            $count = 0;
            $productList = "\nНайдено:";
            foreach ($productArray as $product) {
                $product     = $this->getJsonFromProductObject($product);
                $productList .= "\n" . ++$count . ". " . $product;
            }
        }

        return $productList ?: ServiceMessage::ProductFindError->value;
    }

    public function update(string $json): string
    {
        $productAsArray = $this->jsonToArray($json);
        $product = $this->buildProductFromArray($productAsArray);
        $result = $this->service->update($product);

        return $result ?
                ServiceMessage::ProductUpdateSuccess->value
                : ServiceMessage::ProductFindError->value;
    }

    public function create(string $json): string
    {
        $productAsArray = $this->jsonToArray($json);
        $product = $this->buildProductFromArray($productAsArray);
        $product = $this->service->create($product);

        if (!$product) {
            return  ServiceMessage::ProductCreateError->value;
        }
        $result  = $this->getJsonFromProductObject($product);

        return ServiceMessage::ProductCreateSuccess->value . $result;
    }

    public function remove(string $json): string
    {
        $product = $this->service->findById($this->jsonToArray($json)['id']);

        if ($product) {
            $result = $this->service->remove($product);
        }

        return $result ?
            ServiceMessage::ProductRemoveSuccess->value
            : ServiceMessage::ProductFindError->value;
    }

    private function jsonToArray(string $json): array
    {
        return json_decode($json, true);
    }

    private function getJsonFromProductObject(Product $product): string
    {
        return json_encode($this->getArrayFromProductObject($product), JSON_UNESCAPED_UNICODE);
    }

    private function getArrayFromProductObject(Product $product): array
    {
        return [
            'id' => $product->getId(),
            'title' => $product->getTitle(),
            'sku' => $product->getSku(),
            'category' => $product->getCategory(),
            'price' => $product->getPrice(),
            'volume' => $product->getvolume()
        ];
    }

    private function buildProductFromArray(array $productAsArray): Product
    {
        return new Product(
            $productAsArray['id'],
            $productAsArray['title'],
            $productAsArray['sku'],
            $productAsArray['category'],
            $productAsArray['price'],
            $productAsArray['volume']
        );
    }
}
