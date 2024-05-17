<?php

declare(strict_types=1);

namespace App\Layer\Domain\Entity\EntityInterface;

interface CompositeInterface extends CompositeItemInterface
{
    public function setChildItem(CompositeItemInterface $item);
}
