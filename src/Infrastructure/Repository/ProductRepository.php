<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Product;
use App\Domain\Enum\ServiceMessage;
use App\Domain\Model\Product\ProductUpdate\ProductUpdateModel;
use App\Domain\Service\ConfigService;
use App\Infrastructure\DataMapper\ProductDataMapper;

class ProductRepository
{
    private ProductDataMapper $mapper;

    private ConfigService $config;

    public function __construct()
    {
        $this->mapper = new ProductDataMapper();
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

    public function update(ProductUpdateModel $model): bool
    {
        if (!$this->findById($model->id)) {
            return false;
        }

        return $this->mapper->update($model);
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
        $productCount = 0;

        foreach ($fileAsArray as $row) {
            $row = $this->jsonToArray($row);
            if (array_key_exists('title', $row)) {
                $this->create(
                    new Product(
                        $row['sku'],
                        $row['title'],
                        $row['sku'],
                        $row['category'],
                        $row['price'],
                        $row['volume']
                    )
                );
                $productCount++;
            }
        }

        if ($productCount === 0) {
            return ServiceMessage::ProductLoadError->value;
        }

        return ServiceMessage::ProductLoadSuccess->value . $productCount;
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
