<?php

namespace Otus\Hw16\Infrastructure\Proxy;

use Otus\Hw16\Domain\Entity\FoodItem;
use Otus\Hw16\Domain\Service\CookingServiceInterface;

class CookingProxy implements CookingServiceInterface
{
    public function __construct(
        private CookingServiceInterface $cookingService
    ) {
    }

    public function cook(FoodItem $foodItem): bool
    {
        $this->validateIngredients($foodItem);

        $result = $this->cookingService->cook($foodItem);

        if (!$this->checkStandard($foodItem)) {
            $this->dispose($foodItem);
            throw new \RuntimeException("Food item ID {$foodItem->getId()} rejected due to insufficient ingredients");
        }

        return $result;
    }

    private function validateIngredients(FoodItem $foodItem): void
    {
        if (empty($foodItem->getIngredients())) {
            throw new \InvalidArgumentException('FoodItem must have at least one ingredient');
        }
    }

    private function checkStandard(FoodItem $foodItem): bool
    {
        return count($foodItem->getIngredients()) >= 3;
    }

    private function dispose(FoodItem $foodItem): void
    {
        // Детализированная логика утилизации
        $reason = 'Insufficient ingredients: ' . count($foodItem->getIngredients()) . ' found, 3 or more required';
        error_log("Food item ID {$foodItem->getId()} disposed. Reason: $reason");
        // Здесь можно добавить дополнительные действия:
        // - Отправка уведомления администратору
        // - Запись в специальную таблицу утилизации
        // - Интеграция с внешней системой
    }
}
