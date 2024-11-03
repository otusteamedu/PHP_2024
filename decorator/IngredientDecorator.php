<?php

abstract class IngredientDecorator extends Product {
    protected $product;

    public function __construct(Product $product) {
        $this->product = $product;
    }

    public abstract function getDescription(): string;
}
