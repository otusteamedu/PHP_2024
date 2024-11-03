<?php

class Burger extends Product {
    protected $description = "Burger";

    public function cost(): float {
        return 5.00; // базовая цена
    }
}
