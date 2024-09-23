<?php

class BurgerFactory implements ProductFactoryInterface
{
    public function make(): ProductInterface
    {
        return new Burger();
    }
}