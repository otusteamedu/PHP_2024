<?php

class Product
{
    private $parts = [];

    public function addPart($part)
    {
        $this->parts[] = $part;
    }

    public function listParts()
    {
        echo "Продукт состоит из: " . implode(', ', $this->parts) . "\n";
    }
}

// Интерфейс строителя
interface Builder
{
    public function buildPartA();

    public function buildPartB();

    public function buildPartC();

    public function getProduct(): Product;
}

// Конкретный строитель
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

class Director
{
    private $builder;

    public function setBuilder(Builder $builder)
    {
        $this->builder = $builder;
    }

    public function buildMinimalProduct()
    {
        $this->builder->buildPartA();
    }

    public function buildFullFeaturedProduct()
    {
        $this->builder->buildPartA();
        $this->builder->buildPartB();
        $this->builder->buildPartC();
    }
}

$builder = new ConcreteBuilder();
$director = new Director();

$director->setBuilder($builder);
$director->buildMinimalProduct();
$product = $builder->getProduct();
$product->listParts();

echo "\n";

$director->buildFullFeaturedProduct();
$product = $builder->getProduct();
$product->listParts();
