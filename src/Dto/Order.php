<?php

declare(strict_types=1);

namespace App\Dto;

use App\Exception\InvalidArgumentException;

class Order
{
    /** @param OrderProduct[] $items
     * @throws InvalidArgumentException
     */
    public function __construct(public array $items)
    {
        foreach ($this->items as $item) {
            if (!$item instanceof OrderProduct) {
                throw new InvalidArgumentException('Order product must be instance of OrderProduct');
            }
        }
    }
}
