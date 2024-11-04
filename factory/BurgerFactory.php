<?php

class BurgerFactory implements ProductFactory {
    public function createProduct(): Product {
        return new Burger();
    }
}
