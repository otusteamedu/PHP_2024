<?php

declare(strict_types=1);

namespace Otus\Hw16\Infrastructure\Observer;

use Otus\Hw16\Domain\Entity\CookingProcess;
use Otus\Hw16\Domain\Entity\OrderStatusHistory;
use Otus\Hw16\Domain\Observer\CookingStatusObserverInterface;
use Otus\Hw16\Domain\Repository\FoodItemRepositoryInterface;

class CookingStatusObserver implements CookingStatusObserverInterface
{
    public function __construct(
        private FoodItemRepositoryInterface $repository,
        private int $foodItemId
    ) {
    }

    public function update(\SplSubject $subject): void
    {
        if ($subject instanceof CookingProcess) {
            $status = match ($subject->getStatus()) {
                'cooking' => 'Cooking',
                'completed' => 'Created',
                'rejected' => 'Rejected',
                default => null
            };

            if ($status) {
                $this->repository->saveStatusHistory(new OrderStatusHistory($this->foodItemId, $status));
            }
        }
    }
}
