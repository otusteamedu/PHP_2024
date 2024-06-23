<?php

declare(strict_types=1);

namespace App\Food\Product\Composite;

use App\Exception\InvalidArgumentException;
use App\Food\Ingredient;
use App\Food\Product\Proxy\ProductProxy;
use App\ObjectValue\Money;

class Sandwich extends ProductProxy
{
    /**
     * @throws InvalidArgumentException
     */
    public function __construct()
    {
        parent::__construct('Сандвич');
        $this->addIngredient(new Ingredient('Хлеб', new Money(100)));
        $this->addIngredient(new Ingredient('Пепперони', new Money(50)));
        $this->addIngredient(new Ingredient('Салями', new Money(50)));
        $this->addIngredient(new Ingredient('Салат', new Money(50)));
        $this->addIngredient(new Ingredient('Помидоры', new Money(10)));
        $this->addIngredient(new Ingredient('Огурчики', new Money(20)));
        $this->addIngredient(new Ingredient('Перец', new Money(30)));
        $this->addIngredient(new Ingredient('Лук', new Money(5)));
        $this->addIngredient(new Ingredient('Халапеньо', new Money(5)));
        $this->addIngredient(new Ingredient('Майонезный соус', new Money(20)));
    }
}
