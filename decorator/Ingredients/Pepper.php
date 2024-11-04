<?php

class Pepper extends IngredientDecorator {
    public function getDescription(): string {
        return $this->product->getDescription() . ", Pepper";
    }

    public function cost(): float {
        return $this->product->cost() + 0.20; // Цена за добавление перца
    }
}
