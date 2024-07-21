<?php

declare(strict_types=1);

namespace App\old\Application\UseCase;

use App\old\Application\UseCase\Request\SearchBookRequest;
use App\old\Application\UseCase\Response\SearchBookResponse;
use App\old\Domain\Repository\BookRepositoryInterface;

class SearchBookUseCase
{
    private $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function execute(SearchBookRequest $searchBookRequest): SearchBookResponse
    {
        $bookCollection = $this->bookRepository->search(
            $searchBookRequest->title,
            $searchBookRequest->category,
            $searchBookRequest->minPrice,
            $searchBookRequest->maxPrice,
            $searchBookRequest->shopName,
            $searchBookRequest->minStock,
        );

        return new SearchBookResponse(
            $bookCollection
        );
    }
}
