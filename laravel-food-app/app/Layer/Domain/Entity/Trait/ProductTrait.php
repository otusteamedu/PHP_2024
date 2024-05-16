<?php

declare(strict_types=1);

namespace App\Layer\Domain\Entity\Trait;

use App\Layer\Domain\Entity\EntityInterface\ProductInterface;
use App\Layer\Domain\Entity\Product\StatusProduct\StatusProduct;
use App\Layer\Domain\Entity\Product\StatusProduct\StatusProductIterator;

trait ProductTrait
{
    private $status;
    private string $name;
    private ProductInterface $strategy;
    public $price;
    public function setName(): void
    {
        $this->name = $this->strategy->getName();
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param ProductInterface $strategy
     */
    public function setStrategy(ProductInterface $strategy): void
    {
        $this->strategy = $strategy;
    }

    public function createNewProduct()
    {
        return $this->strategy->createProduct();
    }

    public function addStatusProduct(): void
    {
        $statusProductIterator = new StatusProductIterator($this->status);
        $this->status = $statusProductIterator->nextStatus();
    }

    public function setStatusProduct(StatusProduct $statusProduct): void
    {
        $statusProductIterator = new StatusProductIterator($statusProduct);
        $this->status = $statusProduct;
        $statusProductIterator->notifyStatusChange();
    }

    public function getStatusProduct()
    {
        return $this->status;
    }
}
