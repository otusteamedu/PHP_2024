<?php

namespace Naimushina\ElasticSearch\Entities;

class Book
{
    /**
     * @param string $title
     * @param string $sku
     * @param string $category
     * @param float $price
     * @param array $stock
     */
    public function __construct(
        private string $title,
        private string $sku,
        private string $category,
        private float $price,
        private array $stock
    ) {
    }

    /**
     * @return float|int
     */
    public function getCount(): float|int
    {
        return array_sum(array_column($this->stock, 'stock'));
    }

    /**
     * @param array $filter
     * @return array
     */
    public function toArray(array $filter): array
    {
        $params = get_object_vars($this);

        return array_filter($params, function ($param) use ($filter) {
            return in_array($param, $filter);
        }, ARRAY_FILTER_USE_KEY);
    }
}
