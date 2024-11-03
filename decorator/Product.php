<?php

abstract class Product {
    protected $description = "Base Product";

    public function getDescription(): string {
        return $this->description;
    }

    public abstract function cost(): float;
}
