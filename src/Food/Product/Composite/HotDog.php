<?php

declare(strict_types=1);

namespace App\Food\Product\Composite;

use App\Food\Ingredient;
use App\Food\Product\Proxy\ProductProxy;
use App\ObjectValue\Money;

class HotDog extends ProductProxy
{
    /**
     * @throws \InvalidArgumentException
     */
    public function __construct()
    {
        parent::__construct('Хот-дог');
        $this->addIngredient(new Ingredient('Длинная куриная сосиска', new Money(100)));
        $this->addIngredient(new Ingredient('Горчица', new Money(50)));
        $this->addIngredient(new Ingredient('Салат', new Money(50)));
        $this->addIngredient(new Ingredient('Помидоры', new Money(10)));
        $this->addIngredient(new Ingredient('Огурец', new Money(20)));
        $this->addIngredient(new Ingredient('Перец', new Money(30)));
        $this->addIngredient(new Ingredient('Белый винный уксус', new Money(10)));
        $this->addIngredient(new Ingredient('Фиолетовый лук', new Money(20)));
        $this->addIngredient(new Ingredient('Мягкая булочка', new Money(80)));
    }
}
