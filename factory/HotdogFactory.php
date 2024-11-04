<?php

class HotdogFactory implements ProductFactory {
    public function createProduct(): Product {
        return new Burger();
    }
}
