<?php

class ProductStatus implements Subject {
    private $observers = [];
    private $status = "";

    public function attach(Observer $observer) {
        $this->observers[] = $observer;
    }

    public function detach(Observer $observer) {
        // Удаление наблюдателя из списка
    }

    public function notify() {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    public function setStatus(string $status) {
        $this->status = $status;
        $this->notify();
    }

    public function getStatus(): string {
        return $this->status;
    }
}
