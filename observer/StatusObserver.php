<?php

class StatusObserver implements Observer {
    public function update(ProductStatus $status) {
        echo "Статус продукта изменился: " . $status->getStatus();
    }
}
