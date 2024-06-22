<?php

declare(strict_types=1);

namespace App\Kitchen;

use App\Exception\InvalidArgumentException;
use App\Food\Ingredient;
use App\Food\Product;
use App\ObjectValue\Money;

class Kitchen implements KitchenInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function makeBurger(): Product
    {
        $product = new Product('Бургер');

        $product->addIngredient(new Ingredient('Котлета говядина', new Money(100)));
        $product->addIngredient(new Ingredient('Майонез', new Money(50)));
        $product->addIngredient(new Ingredient('Салат Айсберг', new Money(50)));
        $product->addIngredient(new Ingredient('Томаты', new Money(50)));
        $product->addIngredient(new Ingredient('Лук репчатый', new Money(10)));
        $product->addIngredient(new Ingredient('Огурцы маринованные', new Money(60)));
        $product->addIngredient(new Ingredient('Кетчуп', new Money(10)));
        $product->addIngredient(new Ingredient('Булочка для гамбургера с кунжутом', new Money(70)));

        return $product;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function makeSandwich(): Product
    {
        $product = new Product('Сэндвич');

        $product->addIngredient(new Ingredient('Хлеб', new Money(100)));
        $product->addIngredient(new Ingredient('Пепперони', new Money(50)));
        $product->addIngredient(new Ingredient('Салями', new Money(50)));
        $product->addIngredient(new Ingredient('Салат', new Money(50)));
        $product->addIngredient(new Ingredient('Помидоры', new Money(10)));
        $product->addIngredient(new Ingredient('Огурчики', new Money(20)));
        $product->addIngredient(new Ingredient('Перец', new Money(30)));
        $product->addIngredient(new Ingredient('Лук', new Money(5)));
        $product->addIngredient(new Ingredient('Халапеньо', new Money(5)));
        $product->addIngredient(new Ingredient('Майонезный соус', new Money(20)));

        return $product;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function makeHotDog(): Product
    {
        $product = new Product('Хот-дог');

        $product->addIngredient(new Ingredient('Длинная куриная сосиска', new Money(100)));
        $product->addIngredient(new Ingredient('Горчица', new Money(50)));
        $product->addIngredient(new Ingredient('Салат', new Money(50)));
        $product->addIngredient(new Ingredient('Помидоры', new Money(10)));
        $product->addIngredient(new Ingredient('Огурец', new Money(20)));
        $product->addIngredient(new Ingredient('Перец', new Money(30)));
        $product->addIngredient(new Ingredient('Белый винный уксус', new Money(10)));
        $product->addIngredient(new Ingredient('Фиолетовый лук', new Money(20)));
        $product->addIngredient(new Ingredient('Мягкая булочка', new Money(80)));

        return $product;
    }
}
