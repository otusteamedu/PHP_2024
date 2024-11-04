<?php

class SendwichFactory implements ProductFactory {
    public function createProduct(): Product {
        return new Burger();
    }
}
