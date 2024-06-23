<?php

declare(strict_types=1);

namespace App\Food\Product\Composite;

use App\Exception\InvalidArgumentException;
use App\Food\Ingredient;
use App\Food\Product\Proxy\ProductProxy;
use App\ObjectValue\Money;

class Burger extends ProductProxy
{
    /**
     * @throws InvalidArgumentException
     */
    public function __construct()
    {
        parent::__construct('Бургер');
        $this->addIngredient(new Ingredient('Котлета говядина', new Money(100)));
        $this->addIngredient(new Ingredient('Майонез', new Money(50)));
        $this->addIngredient(new Ingredient('Салат Айсберг', new Money(50)));
        $this->addIngredient(new Ingredient('Томаты', new Money(50)));
        $this->addIngredient(new Ingredient('Лук репчатый', new Money(10)));
        $this->addIngredient(new Ingredient('Огурцы маринованные', new Money(60)));
        $this->addIngredient(new Ingredient('Кетчуп', new Money(10)));
        $this->addIngredient(new Ingredient('Булочка для гамбургера с кунжутом', new Money(70)));
    }
}
