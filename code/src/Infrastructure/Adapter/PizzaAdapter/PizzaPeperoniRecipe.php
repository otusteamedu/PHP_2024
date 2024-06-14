<?php
declare(strict_types=1);

namespace App\Infrastructure\Adapter\PizzaAdapter;


use App\Application\Interface\RecipeInterface;

class PizzaPeperoniRecipe implements RecipeInterface
{

    private array $recipe;

    public function __construct()
    {
        $this->recipe = [
            'Тесто для пиццы',
            'колбаса пеперони',
            'лук',
            'специи',
            'сыр',
            'кетчуп'
        ];
    }

    public function getRecipe(): string
    {
        $strRecipe = '';
        foreach ($this->recipe as $ingredient) {
            $strRecipe .= $ingredient.',';
        }
        return $strRecipe;
    }

}