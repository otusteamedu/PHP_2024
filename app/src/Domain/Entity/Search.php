<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Query;
use App\Domain\ValueObject\Gte;
use App\Domain\ValueObject\Lte;
use App\Domain\ValueObject\Category;
use App\Domain\ValueObject\Shop;

/**
 * Search entity.
 */
class Search
{
    /**
     * Construct.
     */
    public function __construct(
        private Query $query,
        private Gte $gte,
        private Lte $lte,
        private Category $category,
        private Shop $shop
    ) {}

    /**
     * Get query.
     */
    public function getQuery(): Query
    {
        return $this->query;
    }

    /**
     * Get gte.
     * @return Gte
     */
    public function getGte(): Gte
    {
        return $this->gte;
    }

    /**
     * Get lte.
     * @return Lte
     */
    public function getLte(): Lte
    {
        return $this->lte;
    }

    /**
     * Get category.
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * Get shop.
     * @return Shop
     */
    public function getShop(): Shop
    {
        return $this->shop;
    }

    /**
     * Set query.
     * @param Query $query
     * @return self
     */
    public function setQuery(Query $query): self
    {
        $this->query = $query;
        return $this;
    }

    /**
     * Set gte.
     * @param Gte $gte
     * @return self
     */
    public function setGte(Gte $gte): self
    {
        $this->gte = $gte;
        return $this;
    }

    /**
     * Set lte.
     * @param Lte $lte
     * @return self
     */
    public function setLte(Lte $lte): self
    {
        $this->lte = $lte;
        return $this;
    }

    /**
     * Set category.
     * @param Category $category
     * @return self
     */
    public function setCategory(Category $category): self
    {
        $this->category = $category;
        return $this;
    }

    /**
     * Set shop.
     * @param Shop $shop
     * @return self
     */
    public function setShop(Shop $shop): self
    {
        $this->shop = $shop;
        return $this;
    }
}
