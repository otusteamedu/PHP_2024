<?php

declare(strict_types=1);

namespace Otus\Hw16\Infrastructure\Observer;

use Otus\Hw16\Application\Service\CookingStatusObserverFactoryInterface;
use Otus\Hw16\Domain\Observer\CookingStatusObserverInterface;
use Otus\Hw16\Domain\Repository\FoodItemRepositoryInterface;

class CookingStatusObserverFactory implements CookingStatusObserverFactoryInterface
{
    public function __construct(
        private FoodItemRepositoryInterface $repository
    ) {
    }

    public function create(int $foodItemId): CookingStatusObserverInterface
    {
        return new CookingStatusObserver($this->repository, $foodItemId);
    }
}
