<?php

declare(strict_types=1);

namespace App\Layer\Domain\Entity\Order;

use App\Layer\Domain\Entity\EntityInterface\CompositeInterface;
use App\Layer\Domain\Entity\Trait\CompositeTrait;

class Order implements CompositeInterface
{
    public $price;

    use CompositeTrait;
}
