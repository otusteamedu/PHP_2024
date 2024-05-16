<?php

declare(strict_types=1);

namespace App\Layer\Domain\Entity\Product;

use App\Layer\Domain\Entity\EntityInterface\CompositeInterface;
use App\Layer\Domain\Entity\EntityInterface\ProductInterface;
use App\Layer\Domain\Entity\Product\Ingredient\Ingredient;
use App\Layer\Domain\Entity\Trait\CompositeTrait;

class Sandwich implements ProductInterface, CompositeInterface
{
    use CompositeTrait;

    private function getIngredients(): array
    {
        return [
            [
                "name" => "тост",
                "price" => 5
            ],
            [
                "name" => "индейка",
                "price" => 10
            ],
            [
                "name" => "салат Айсберг",
                "price" => 5
            ],
            [
                "name" => "сыр Гауда",
                "price" => 6
            ],
            [
                "name" => "соус Сендвич",
                "price" => 5
            ],
            [
                "name" => "помидор",
                "price" => 5
            ],
        ];
    }

    public function getName(): string
    {
        return "Sandwich";
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
