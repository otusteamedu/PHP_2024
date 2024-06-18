<?php
declare(strict_types=1);

namespace App\Infrastructure\Adapter\PizzaAdapter;


use App\Application\Interface\RecipeInterface;

class PizzaPeperoniRecipe implements PizzaInterface
{

    private array $recipe;

    public function __construct()
    {
        $this->recipe = [
            'колбаса пеперони',
            'лук',
            'специи',
            'сыр',
            'кетчуп'
        ];
    }

    public function getPizza(): string
    {
        $strRecipe = $this->getSpecialDough();
        foreach ($this->recipe as $ingredient) {
            $strRecipe .= $ingredient.',';
        }
        return $strRecipe;
    }

    public function getSpecialDough(): string
    {
        return 'Специальное тесто для пиццы, ';
    }
}