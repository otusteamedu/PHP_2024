<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Response\SearchBookResponse;
use App\Application\UseCase\Request\SearchBookRequest;
use App\Domain\Repository\BookRepositoryInterface;

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
