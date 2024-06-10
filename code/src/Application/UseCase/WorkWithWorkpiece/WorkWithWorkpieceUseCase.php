<?php
declare(strict_types=1);

namespace App\Application\UseCase\WorkWithWorkpiece;

use App\Application\Interface\StrategyInterface;
use App\Application\UseCase\Response\Response;
use App\Domain\Entity\Product;
use App\Domain\Repository\RepositoryInterface;

readonly class WorkWithWorkpieceUseCase
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
        $id = $this->repository->save($product);
        return new Response($product->getStatus(),$product->getRecipe(),$id);
    }

    public function changeStatus(Response $response): void
    {
        $this->repository->setStatus($response->status,$response->id);
    }

}