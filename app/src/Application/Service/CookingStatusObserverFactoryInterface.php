<?php

declare(strict_types=1);

namespace Otus\Hw16\Application\Service;

use Otus\Hw16\Domain\Observer\CookingStatusObserverInterface;

interface CookingStatusObserverFactoryInterface
{
    public function create(int $foodItemId): CookingStatusObserverInterface;
}