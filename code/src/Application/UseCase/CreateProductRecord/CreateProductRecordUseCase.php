<?php
declare(strict_types=1);

namespace App\Application\UseCase\CreateProductRecord;

use App\Application\UseCase\Response\Response;
use App\Domain\Entity\Product;
use App\Domain\Repository\RepositoryInterface;

readonly class CreateProductRecordUseCase
{

    public function __construct(
        private Product $product,
        private RepositoryInterface $repository
    ){}

    public function __invoke(): Response
    {
        $id = $this->repository->save($this->product);
        return new Response($this->product->getStatus(),$this->product->getRecipe(),$id);
    }

}