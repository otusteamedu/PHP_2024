<?php
namespace App;

use App\Events\BurgerEventInterface;
use App\Strategy\BurgerStrategy;

class Builder
{
    private array $ingredients = [];
    private Burger $inProgressBurger;
    private ?BurgerEventInterface $events = null;

    public function __construct(BurgerStrategy $strategy)
    {
        $this->ingredients = $strategy->getIngredients();
        $this->inProgressBurger = new Burger($this->ingredients);
    }

    public function setEvents(BurgerEventInterface $events): self
    {
        $this->events = $events;
        return $this;
    }

    public function getInProgressBurger(): Burger
    {
        return $this->inProgressBurger;
    }


    public function addIngredient(string $ingredient): self
    {
        $this->ingredients[] = $ingredient;
        echo "Builder: added ingredient - $ingredient<br>";
        return $this;
    }

    public function removeIngredient(string $ingredient): self
    {
        $index = array_search($ingredient, $this->ingredients);
        if ($index !== false) {
            unset($this->ingredients[$index]);
            echo "Builder: removed ingredient - $ingredient<br>";
            // Re-index array after removal
            $this->ingredients = array_values($this->ingredients);
        } else {
            echo "Builder: ingredient not found - $ingredient<br>";
        }
        return $this;
    }

    public function build(): Burger
    {
        $burger = new Burger($this->ingredients);

        if ($this->events) {
            $this->events->postProcess($burger);
        }
        return $burger;
    }
}
