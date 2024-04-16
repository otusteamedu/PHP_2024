<?php

declare(strict_types=1);

namespace AlexanderGladkov\Bookshop\Application\Action;

use AlexanderGladkov\Bookshop\Index\Index;
use AlexanderGladkov\Bookshop\Index\SearchParams;
use AlexanderGladkov\Bookshop\Index\SearchResult;
use LucidFrame\Console\ConsoleTable;

class SearchAction extends BaseAction
{
    public function run(array $args = []): Response
    {
        $searchParams = SearchParams::createFromArgs($args);
        $index = new Index($this->elasticsearchClient);
        $searchResult = $index->search($searchParams);
        if ($searchResult->getTotalCount() === 0) {
            return new Response('Nothing is found!' . PHP_EOL);
        }

        $consoleTable = $this->crateConsoleTableWithSearchResult($searchResult);
        return new Response($consoleTable->getTable());
    }

    private function crateConsoleTableWithSearchResult(SearchResult $searchResult): ConsoleTable
    {
        $consoleTable = new ConsoleTable();
        $consoleTable
            ->addHeader('Title')
            ->addHeader('SKU')
            ->addHeader('Category')
            ->addHeader('Price')
            ->addHeader('Stock');

        foreach ($searchResult->getHits() as $hit) {
            $stocksArr = array_map(function($stock) {
                return $stock['shop'] . ' - ' . $stock['stock'];
            }, $hit['stock']);
            $stocksOneLine = implode('; ', $stocksArr);

            $consoleTable->addRow()
                ->addColumn($hit['title'])
                ->addColumn($hit['sku'])
                ->addColumn($hit['category'])
                ->addColumn($hit['price'])
                ->addColumn($stocksOneLine);
        }
        return $consoleTable;
    }
}
