<?php

declare(strict_types=1);

namespace AlexanderGladkov\Bookshop\Index;

use AlexanderGladkov\Bookshop\Elasticsearch\BoolQuery;
use AlexanderGladkov\Bookshop\Elasticsearch\QueryBuildHelper;

class SearchParams
{
    private ?string $title = null;
    private ?string $category = null;
    private ?int $priceFrom = null;
    private ?int $priceTo = null;
    private ?string $shop = null;
    private ?int $stock = null;
    private int $page;
    private int $pageSize;

    private function __construct()
    {
    }

    public static function createFromArgs(array $args): self
    {
        $searchParams = new self();
        $args = (new SearchParamsValidation())->validateArgs($args);
        foreach ($args as $argName => $value) {
            $searchParams->$argName = $value;
        }

        return $searchParams;
    }

    public function generateSearchRequestBody(): array
    {
        return [
            'from' => ($this->page - 1) * $this->pageSize,
            'size' => $this->pageSize,
            'query' => $this->generateSearchQuery(),
        ];
    }

    private function generateSearchQuery(): array
    {
        $queryBuildHelper = new QueryBuildHelper();
        if ($this->areAllQueryParamsEmpty()) {
            return $queryBuildHelper->matchAll();
        }

        $boolQuery = new BoolQuery();
        if ($this->title !== null) {
            $boolQuery->addToMust($queryBuildHelper->matchFuzziness('title', $this->title, 'auto'));
        }

        if ($this->category !== null) {
            $boolQuery->addToMust($queryBuildHelper->term('category', $this->category));
        }

        if ($this->priceFrom !== null) {
            $boolQuery->addToFilter($queryBuildHelper->rangeGte('price', $this->priceFrom));
        }

        if ($this->priceTo !== null) {
            $boolQuery->addToFilter($queryBuildHelper->rangeLte('price', $this->priceTo));
        }

        if ($this->shop !== null || $this->stock !== null) {
            $boolQuery->addToMust($this->generateStockDataNestedQuery());
        }

        return $boolQuery->asArray();
    }


    private function generateStockDataNestedQuery(): array
    {
        $queryBuildHelper = new QueryBuildHelper();
        $boolQuery = new BoolQuery();
        if ($this->shop !== null) {
            $boolQuery->addToMust($queryBuildHelper->matchFuzziness('stock.shop', $this->shop, 'auto'));
        }

        if ($this->stock !== null) {
            $boolQuery->addToFilter($queryBuildHelper->rangeGte('stock.stock', $this->stock));
        }

        return $queryBuildHelper->nested('stock', $boolQuery->asArray());
    }

    private function areAllQueryParamsEmpty(): bool
    {
        return
            $this->title === null &&
            $this->category === null &&
            $this->priceFrom === null &&
            $this->priceTo === null &&
            $this->shop === null &&
            $this->stock === null;
    }
}
