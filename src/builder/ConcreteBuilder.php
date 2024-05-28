<?php

namespace Ahar\Hw16\builder;

class ConcreteBuilder implements Builder
{
    private $product;

    public function __construct()
    {
        $this->reset();
    }

    public function reset()
    {
        $this->product = new Product();
    }

    public function buildPartA()
    {
        $this->product->addPart("Часть A");
    }

    public function buildPartB()
    {
        $this->product->addPart("Часть B");
    }

    public function buildPartC()
    {
        $this->product->addPart("Часть C");
    }

    public function getProduct(): Product
    {
        $product = $this->product;
        $this->reset();
        return $product;
    }
}
