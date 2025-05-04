<?php
namespace App;

class Burger
{
    private array $ingredients;

    public function __construct(array $ingredients)
    {
        $this->ingredients = $ingredients;
    }

    public function getDescription(): string
    {
        return 'Burger with: ' . implode(', ', $this->ingredients) . "<br>";
    }
}
