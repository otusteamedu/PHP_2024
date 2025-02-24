<?php

declare(strict_types=1);

namespace Otus\Hw16\Application\Handler;

use Otus\Hw16\Application\Command\CookFoodItemCommand;
use Otus\Hw16\Domain\Chain\CookingHandlerInterface;
use Otus\Hw16\Domain\Entity\CookingProcess;
use Otus\Hw16\Domain\Service\CookingServiceInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CookFoodItemHandler
{
    public function __construct(
        private CookingServiceInterface $cookingService,
        private CookingHandlerInterface $cookingHandler,
        private CookingProcess $cookingProcess
    ) {
    }

    public function __invoke(CookFoodItemCommand $command): void
    {
        $foodItem = $command->getFoodItem();
        $observer = $command->getObserver();

        $this->cookingProcess->attach($observer);

        try {
            // Сначала проверяем возможность приготовления
            $isCooked = $this->cookingService->cook($foodItem);
            if (!$isCooked) {
                throw new \RuntimeException("Cooking failed for item ID {$foodItem->getId()}");
            }

            // Если приготовление возможно, устанавливаем статус Cooking
            $this->cookingProcess = $this->cookingProcess->withStatus('cooking');
            $this->cookingHandler->handle($foodItem);
            $this->cookingProcess = $this->cookingProcess->withStatus('completed');
        } catch (\RuntimeException $e) {
            $this->cookingProcess = $this->cookingProcess->withStatus('rejected');
            throw $e;
        } finally {
            $this->cookingProcess->detach($observer);
        }
    }
}
