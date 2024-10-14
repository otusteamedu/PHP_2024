<?php

declare(strict_types=1);

namespace App\Shop\Repository;

use App\Shared\Repository\RepositoryInterface;
use App\Shared\Search\SearchClientInterface;
use App\Shared\Search\SearchCriteria;
use App\Shared\Search\SearchResults;
use App\Shop\Model\Book;
use App\Shop\Model\Stock;

final readonly class BookRepository implements RepositoryInterface
{
    public function __construct(
        private SearchClientInterface $searchClient,
    ) {}

    public function search(?SearchCriteria $searchCriteria = null): SearchResults
    {
        $items = array_map(function (array $item): Book {
            $item = $item['_source'];

            $stocks = array_map(function (array $item): Stock {
                return new Stock(
                    $item['shop'],
                    $item['stock'],
                );
            }, $item['stock']);

            return new Book(
                $item['title'],
                $item['sku'],
                $item['category'],
                $item['price'],
                $stocks
            );
        }, $this->searchClient->search('otus-shop', $searchCriteria));

        return new SearchResults($items);
    }
}
