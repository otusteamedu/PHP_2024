<?php

namespace AnatolyShilyaev\App\Domain\Product\Services;

use AnatolyShilyaev\App\Domain\Product\Entity\Product;
use AnatolyShilyaev\App\Domain\Product\Interfaces\ProductObserverInterface;

class ProductStatusNotifier
{
    /** @var ProductObserverInterface[] */
    private array $observers = [];

    public function attach(ProductObserverInterface $observer): void
    {
        $this->observers[] = $observer;
    }

    public function detach(ProductObserverInterface $observer): void
    {
        $this->observers = array_filter(
            $this->observers,
            fn($obs) => $obs !== $observer
        );
    }

    public function notify(Product $product): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($product);
        }
    }
}
