<?php
namespace App\Events;

use App\Burger;

class QualityControlEvent implements BurgerEventInterface
{
    public function preProcess(Burger $burger): void
    {
        echo "Quality Control: Checking ingredients before assembly<BR>";
    }

    public function postProcess(Burger $burger): void
    {
        echo "Quality Control: Inspecting finished burger<BR>";

        if (!$this->isBurgerValid($burger)) {
            echo "!!! Burger failed quality check. Disposing... !!!<BR>";
            $this->disposeBurger($burger);
        } else {
            echo "Burger passed quality control<BR>";
        }
    }

    private function isBurgerValid(Burger $burger): bool
    {
        $ingredients = $burger->getIngredients();
        return in_array('bun', $ingredients) &&
            (in_array('beef-patty', $ingredients) || in_array('chicken-patty', $ingredients));
    }

    private function disposeBurger(Burger $burger): void
    {
        unset($burger);
    }
}