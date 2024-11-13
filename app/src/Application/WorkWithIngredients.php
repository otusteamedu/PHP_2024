<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\Entity\ProductInterface;
use App\Application\BasicProduct;
use App\Domain\Entity\Ingredients\BreadBurger;
use App\Domain\Entity\Ingredients\BreadSandwich;
use App\Domain\Entity\Ingredients\BreadHotdog;
use App\Application\Ingredients\AddCheese;
use App\Application\Ingredients\AddCucumber;
use App\Application\Ingredients\AddHam;
use App\Application\Ingredients\AddMeat;
use App\Application\Ingredients\AddOnion;
use App\Application\Ingredients\AddPepper;
use App\Application\Ingredients\AddSalad;
use App\Application\Ingredients\AddSauce;
use App\Application\Ingredients\AddSausage;

class WorkWithIngredients
{
    public function cook(ProductInterface $product, array $ingredients): ProductInterface
    {
        $productAndIngredients = match (strtolower($product->getName())) {
            'burger' => new BasicProduct(new BreadBurger()),
            'sandwich' => new BasicProduct(new BreadSandwich()),
            'hotdog' => new BasicProduct(new BreadHotdog()),
        };

        foreach ($ingredients as $ingredient) {
            $productAndIngredients = match (strtolower($ingredient->getName())) {
                'cheese' => new AddCheese($productAndIngredients),
                'cucumber' => new AddCucumber($productAndIngredients),
                'ham' => new AddHam($productAndIngredients),
                'meat' => new AddMeat($productAndIngredients),
                'onion' => new AddOnion($productAndIngredients),
                'pepper' => new AddPepper($productAndIngredients),
                'salad' => new AddSalad($productAndIngredients),
                'sauce' => new AddSauce($productAndIngredients),
                'sausage' => new AddSausage($productAndIngredients)
            };
        }

        return $productAndIngredients;
    }
}
