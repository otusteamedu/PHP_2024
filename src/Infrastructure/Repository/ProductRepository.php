<?php

namespace App\Infrastructure\Repository;

use App\Application\DataMapper\ProductMapper;
use App\Controller\Enum\ServiceMessage;
use App\Domain\Entity\Product;
use App\Domain\Service\ConfigService;
use PDOException;

class ProductRepository
{
    private ProductMapper $mapper;

    private ConfigService $config;

    public function __construct()
    {
        $this->mapper = new ProductMapper();
        $this->config = new ConfigService();
    }

    public function create(Product $product): ?Product
    {
        return $this->mapper->insert($product);
    }

    public function findById(string $id): ?Product
    {
        return $this->mapper->findById($id);
    }

    /**
     * @param array $criteriaArray
     * @return Product[]|null
     */
    public function findByCriteria(array $criteriaArray): ?array
    {
        return $this->mapper->findByCriteria($criteriaArray);
    }

    public function update(Product $product): bool
    {
        if (!$this->findById($product->getId())) {
            return false;
        }

        return $this->mapper->update($product);
    }

    public function remove(Product $product): bool
    {
        if (!$this->findById($product->getId())) {
            return false;
        }

        return $this->mapper->delete($product);
    }

    public function loadProductArrayFromFile(string $json)
    {
        $fileAsArray = file($this->getImportFilePath($this->jsonToArray($json)['fileName']));
        $resultArray = [];

        foreach ($fileAsArray as $row) {
            $row = $this->jsonToArray($row);
            if (array_key_exists('title', $row)) {

                $resultArray[] = $this->create(
                    new Product(
                        $row['sku'],
                        $row['title'],
                        $row['sku'],
                        $row['category'],
                        $row['price'],
                        $row['volume']
                    )
                );
            }
        }

        if (array_unique($resultArray)[0] === null) {
            return ServiceMessage::ProductLoadError->value;
        }

        return ServiceMessage::ProductLoadSuccess->value;
    }

    private function getImportFilePath(string $importFileName)
    {
        return
            $this->config::get('POSTGRES_IMPORT_DIR')
            . $importFileName . '.'
            . $this->config::get('POSTGRES_IMPORT_FILE_TYPE');
    }

    private function jsonToArray(string $json): array
    {
        return json_decode($json, true);
    }
}
