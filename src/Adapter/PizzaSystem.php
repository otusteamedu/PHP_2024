<?php

declare(strict_types=1);

namespace App\Adapter;

class PizzaSystem
{
    /**
     * Prepare the pizza dough.
     *
     * @return void
     */
    public function prepareDough(): void
    {
        echo "Preparing pizza dough\n";
    }

    /**
     * Add toppings to the pizza.
     *
     * @param array $toppings The toppings to add.
     * @return void
     */
    public function addToppings(array $toppings): void
    {
        echo "Adding pizza toppings: " . implode(", ", $toppings) . "\n";
    }

    /**
     * Bake the pizza.
     *
     * @param int $minutes The number of minutes to bake.
     * @return void
     */
    public function bake(int $minutes): void
    {
        echo "Baking pizza for {$minutes} minutes\n";
    }


    /**
     * Slice the pizza.
     *
     * @param int $slices The number of slices to cut.
     * @return void
     */
    public function slice(int $slices): void
    {
        echo "Slicing pizza into {$slices} slices\n";
    }

    /**
     * Box the pizza.
     *
     * @return void
     */
    public function box(): void
    {
        echo "Boxing pizza\n";
    }
}
