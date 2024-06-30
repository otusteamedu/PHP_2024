<?php

declare(strict_types=1);

namespace Main\Infrastructure;

/**
 * Class BookParamsQueryBuilder
 *
 * Построитель запросов для поиска книг в Elasticsearch.
 *
 * @property array $indexName Название индекса.
 * @property array $bodyParams Массив для хранения параметров запроса.
 * @property array $toAllBodyParams Массив для получения всех записией Elasticsearch.
 * @property string $title Название книги для поиска.
 * @property string $category Категория книги для поиска.
 * @property int $minPrice Минимальная цена книги для поиска.
 * @property int $maxPrice Максимальная цена книги для поиска.
 * @property string $shopName Название магазина для поиска.
 * @property int $minStock Минимальное количество на складе для поиска.
 */
class BookParamsQueryBuilder implements BookParamsQueryBuilderInterface
{
    private $bodyParams;
    private $toAllBodyParams = [];

    private $indexName;
    private $title;
    private $category;
    private $minPrice;

    private $maxPrice;
    private $shopName;
    private $minStock;

    public function __construct(string $indexName)
    {
        $this->indexName = $indexName;
        $this->toAllBodyParams = [
            'query' => [
                'match_all' => new \stdClass()
            ]
        ];
    }

    public function build():self
    {
        if (!empty($this->title)) {
            $this->bodyParams['query']['bool']['must'][] = ['match' => ['title' => $this->title]];
        }
        if (!empty($this->category)) {
            $this->bodyParams['query']['bool']['must'][] = ['match' => ['category' => $this->category]];
        }
        if (!empty($this->minPrice) && !empty($this->maxPrice)) {
            $this->bodyParams['query']['bool']['must'][] = ['range' => ['price' => ['gte' => $this->minPrice, 'lte' => $this->maxPrice]]];
        }
        if (!empty($this->shopName)) {
            $this->bodyParams['query']['bool']['must'][] = ['match' => ['shop_name' => $this->shopName]];
        }
        if (!empty($this->minStock)) {
            $this->bodyParams['query']['bool']['must'][] = ['range' => ['stock_quantity' => ['gte' => $this->minStock]]];
        }

        return $this;
    }

    public function getBodyParams() :array
    {
        return $this->bodyParams ?? $this->toAllBodyParams;
    }

    public function getQuery(): array
    {
        return [
            'index' => 'otus-shop',
            'body' => $this->getBodyParams()
        ];
    }


     /**
     * @param string $title
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $category
     */
    public function setCategory(string $category): self
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @param int $minPrice
     */
    public function setMinPrice(int $minPrice): self
    {
        $this->minPrice = $minPrice;
        return $this;
    }

    /**
     * @param int $maxPrice
     */
    public function setMaxPrice(int $maxPrice): self
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }

    /**
     * @param string $shopName
     */
    public function setShopName(string $shopName): self
    {
        $this->shopName = $shopName;
        return $this;
    }

    /**
     * @param int $minStock
     */
    public function setMinStock(int $minStock): self
    {
        $this->minStock = $minStock;
        return $this;
    }

}
