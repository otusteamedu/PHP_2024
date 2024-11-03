<?php

class ProductProxy implements ProductInterface {
    private $product;
    private $checker;

    public function __construct(ProductInterface $product, ProductChecker $checker) {
        $this->product = $product;
        $this->checker = $checker;
    }

    public function prepare() {
        echo "Проверка продукта перед готовкой...\n";
        if ($this->checker->check($this->product)) {
            $this->product->prepare();
        } else {
            echo "Продукт не соответствует стандартам, утилизация.\n";
        }
        echo "Готовка завершена.\n";
    }
}
