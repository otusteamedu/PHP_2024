<?php

namespace Otus\Hw16\Application\Service;

use Otus\Hw16\Application\Command\CookFoodItemCommand;
use Otus\Hw16\Domain\Builder\FoodItemBuilderInterface;
use Otus\Hw16\Domain\Entity\OrderStatusHistory;
use Otus\Hw16\Domain\Iterator\IngredientIterator;
use Otus\Hw16\Domain\Repository\FoodItemRepositoryInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class OrderService
{
    public function __construct(
        private FoodItemRepositoryInterface $repository,
        private MessageBusInterface $bus,
        private CookingStatusObserverFactoryInterface $observerFactory
    ) {
    }

    public function orderFoodItem(FoodItemBuilderInterface $builder, array $customIngredients): int
    {
        $foodItem = $builder->setBase()->getProduct();

        $iterator = new IngredientIterator($foodItem, $customIngredients);
        while ($iterator->valid()) {
            $foodItem = $iterator->current();
            $iterator->next();
        }

        $id = $this->repository->save($foodItem);
        $reflection = new \ReflectionProperty($foodItem::class, 'id');
        $reflection->setAccessible(true);
        $reflection->setValue($foodItem, $id);

        $this->repository->saveStatusHistory(new OrderStatusHistory($id, 'Order received'));

        $observer = $this->observerFactory->create($id);
        $command = new CookFoodItemCommand($foodItem, $customIngredients, $observer);
        try {
            $this->bus->dispatch($command);
        } catch (\RuntimeException $e) {
            throw new \RuntimeException("Order ID $id rejected: " . $e->getMessage());
        }

        return $id;
    }
}
