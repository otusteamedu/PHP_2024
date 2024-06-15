<?php

declare(strict_types=1);

namespace Afilipov\Hw16\iterator;

class Product
{
    private array $observers = [];
    private ProductStatus $status;

    public function attach(IObserver $observer): void
    {
        $this->observers[] = $observer;
    }

    public function setStatus(ProductStatus $status): void
    {
        $this->status = $status;
        $this->notify();
    }

    private function notify(): void
    {
        foreach ($this->observers as $observer) {
            /* @var IObserver $observer */
            $observer->update($this->status);
        }
    }
}
