<?php

class Lettuce extends IngredientDecorator {
    public function getDescription(): string {
        return $this->product->getDescription() . ", Lettuce";
    }

    public function cost(): float {
        return $this->product->cost() + 0.25;
    }
}
