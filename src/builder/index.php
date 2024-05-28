<?php

use Ahar\Hw16\builder\ConcreteBuilder;
use Ahar\Hw16\builder\Director;

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
