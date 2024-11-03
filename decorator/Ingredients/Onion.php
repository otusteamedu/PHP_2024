<?php

class Onion extends IngredientDecorator {
    public function getDescription(): string {
        return $this->product->getDescription() . ", Onion";
    }

    public function cost(): float {
        return $this->product->cost() + 0.30; // Цена за добавление лука
    }
}
