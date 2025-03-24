<?php

namespace App\Domain\Entity;

abstract class FoodComposite extends FoodElement
{
    /** @var FoodElement[] array  */
    protected array $foods = [];

    public function add(FoodElement $foodElement): void
    {
        $name = $foodElement->getName();
        $this->foods[$name] = $foodElement;
    }

    public function remove(FoodElement $foodElement): void
    {
        $this->foods = array_filter($this->foods, function ($child) use ($foodElement) {
            return $child != $foodElement;
        });
    }

    public function contains(string $foodClassName): bool
    {
        $this->foods = array_filter($this->foods, function ($child) use ($foodClassName) {
            return $child instanceof $foodClassName;
        });

        return count($this->foods) > 0;
    }

    public function getComposite(): string
    {
        $output = [];

        foreach ($this->foods as $food) {
            $output[] = $food->getComposite();
        }

        return implode(',', $output);
    }
}