<?php

declare(strict_types=1);

namespace App\Adapter;

use App\FoodItem\FoodItemInterface;

class PizzaAdapter implements FoodItemInterface
{
    private PizzaSystem $pizzaSystem;
    private string $type;
    private array $toppings;

    /**
     * Constructor for the PizzaAdapter.
     *
     * @param PizzaSystem $pizzaSystem The pizza system to adapt.
     * @param string $type The type of pizza.
     * @param array $toppings The toppings for the pizza.
     */
    public function __construct(PizzaSystem $pizzaSystem, string $type, array $toppings)
    {
        $this->pizzaSystem = $pizzaSystem;
        $this->type = $type;
        $this->toppings = $toppings;
    }

    /**
     * Prepares the pizza using the adapted pizza system.
     *
     * @return void
     */
    public function prepare(): void
    {
        $this->pizzaSystem->prepareDough();
        $this->pizzaSystem->addToppings($this->toppings);
        $this->pizzaSystem->bake(12);
        $this->pizzaSystem->slice(8);
        $this->pizzaSystem->box();
    }

    /**
     * Returns the description of the pizza.
     *
     * @return string The description of the pizza.
     */
    public function getDescription(): string
    {
        return "{$this->type} Pizza with " . implode(", ", $this->toppings);
    }

    /**
     * Returns the price of the pizza.
     *
     * @return float The price of the pizza.
     */
    public function getPrice(): float
    {
        // Base price plus toppings
        return 8.99 + (count($this->toppings) * 0.75);
    }
}
