<?php

declare(strict_types=1);

namespace App\Dto;

use App\Enum\AdditionIngredientEnum;
use App\Enum\ProductTypeEnum;

class OrderProduct
{
    /** @param AdditionIngredientEnum[] $additionalIngredients
     * @throws \InvalidArgumentException
     */
    public function __construct(
        public ProductTypeEnum $productType,
        public int $quantity,
        public array $additionalIngredients
    ) {
        if ($this->quantity < 1) {
            throw new \InvalidArgumentException('Quantity must be greater than 0');
        }

        foreach ($this->additionalIngredients as $ingredient) {
            if (!$ingredient instanceof AdditionIngredientEnum) {
                throw new \InvalidArgumentException("AdditionIngredient must be additional ingredients enum");
            }
        }
    }
}
