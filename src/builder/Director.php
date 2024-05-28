<?php

namespace Ahar\Hw16\builder;

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
