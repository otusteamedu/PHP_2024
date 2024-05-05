<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Response\SearchProductResponse;
use App\Domain\Entity\Product;
use App\Domain\Exception\DomainException;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Infrastructure\Cli\Parser\ConditionParser;

class SearchProductsUseCase
{
    public function __construct(
        private ConditionParser $conditionParser,
        private ProductRepositoryInterface $repository
    ) {
    }

    /**
     * @param string[] $conditions
     * @return SearchProductResponse[]
     * @throws DomainException
     */
    public function __invoke(array $conditions): array
    {
        $searchConditions = array_map(
            fn (string $con) => $this->conditionParser->parse($con),
            $conditions
        );

        return array_map(
            static fn (Product $product): SearchProductResponse => new SearchProductResponse(
                $product->getId(),
                $product->getTitle(),
                $product->getCategory(),
                $product->getPrice(),
                $product->getStock()
            ),
            $this->repository->search($searchConditions)
        );
    }
}
