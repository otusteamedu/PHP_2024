<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Request\SearchRequest;
use App\Application\UseCase\Response\SearchResponse;
use App\Domain\SearchGateway\SearchGatewayInterface;
use App\Domain\SearchGateway\Request\SearchGatewayRequest;
use App\Domain\Entity\Search;
use App\Domain\ValueObject\Query;
use App\Domain\ValueObject\Gte;
use App\Domain\ValueObject\Lte;
use App\Domain\ValueObject\Category;
use App\Domain\ValueObject\Shop;

/**
 * Search use case.
 */
class SearchUseCase
{
    /**
     * Construct use case.
     */
    public function __construct(
        private SearchGatewayInterface $searchGateway
    ) {
    }

    /**
     * Use case as it is.
     */
    public function __invoke(SearchRequest $request): SearchResponse
    {
        $search = new Search(
            new Query($request->query),
            new Gte($request->gte),
            new Lte($request->lte),
            new Category($request->category),
            new Shop($request->shop)
        );
        $gatewayResponse = $this->searchGateway->search(
            new SearchGatewayRequest(
                (string) $search->getQuery(),
                (int) $search->getGte()
                    ->getValue(),
                (int) $search->getLte()
                    ->getValue(),
                (string) $search->getCategory(),
                (string) $search->getShop()
            )
        );
        return new SearchResponse(
            $gatewayResponse->traces
        );
    }
}
