<?php

namespace Ahar\Hw16\builder;

interface Builder
{
    public function buildPartA();

    public function buildPartB();

    public function buildPartC();

    public function getProduct(): Product;
}
