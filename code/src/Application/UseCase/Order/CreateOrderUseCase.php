<?php
declare(strict_types=1);

namespace App\Application\UseCase\Order;

use App\Application\Interface\StrategyInterface;
use App\Domain\Entity\Product;
use App\Domain\Repository\RepositoryInterface;

class CreateOrderUseCase
{
    private Product $product;
    public function __construct(
        private readonly StrategyInterface $strategy,
        private readonly RepositoryInterface $repository
    ){

        $this->product = new Product(
            $this->strategy->getType(),
            $this->strategy->getRecipe()
        );

    }

    public function __invoke(): Product
    {
        $this->repository->save($this->product);
        return $this->product;
    }

}