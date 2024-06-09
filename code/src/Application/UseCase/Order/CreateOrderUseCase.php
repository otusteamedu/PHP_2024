<?php
declare(strict_types=1);

namespace App\Application\UseCase\Order;

use App\Application\Interface\StrategyInterface;
use App\Application\UseCase\Response\Response;
use App\Domain\Entity\Product;
use App\Domain\Repository\RepositoryInterface;

readonly class CreateOrderUseCase
{

    public function __construct(
        private StrategyInterface   $strategy,
        private RepositoryInterface $repository
    ){}

    public function __invoke(): Response
    {
        $product = new Product(
            $this->strategy->getType(),
            $this->strategy->getRecipe()
        );
        $this->repository->save($product);
        return new Response($product->getStatus());
    }

}