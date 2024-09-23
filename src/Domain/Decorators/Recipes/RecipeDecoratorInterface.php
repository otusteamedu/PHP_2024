<?php

interface RecipeDecoratorInterface
{
    public function __construct(ProductInterface $product);
}