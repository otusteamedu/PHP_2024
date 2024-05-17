<?php

declare(strict_types=1);

namespace App\Layer\Domain\Entity\Product\StrategyProduct;

use App\Layer\Domain\Entity\EntityInterface\CompositeInterface;
use App\Layer\Domain\Entity\EntityInterface\ProductInterface;
use App\Layer\Domain\Entity\Product\Ingredient\Ingredient;
use App\Layer\Domain\Entity\Trait\CompositeTrait;

class Hotdog implements ProductInterface, CompositeInterface
{
    use CompositeTrait;

    private function getIngredients(): array
    {
        return [
            [
                "name" => "булочка с кунжутом",
                "price" => 5
            ],
            [
                "name" => "сосиска",
                "price" => 8
            ],
            [
                "name" => "кетчуп",
                "price" => 5
            ],
            [
                "name" => "майонез",
                "price" => 4
            ],
            [
                "name" => "маринованные огурцы",
                "price" => 6
            ],
        ];
    }

    public function getName(): string
    {
        return "Hotdog";
    }

    public function createProduct(): void
    {
        $ingredients = $this->getIngredients();

        foreach ($ingredients as $ingredient) {
            $ing = new Ingredient();
            $ing->setName($ingredient["name"]);
            $ing->calcPrice($ingredient["price"]);
            $this->setChildItem($ing);
        }
    }
}
