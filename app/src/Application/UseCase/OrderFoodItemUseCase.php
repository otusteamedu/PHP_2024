<?php

declare(strict_types=1);

namespace Otus\Hw16\Application\UseCase;

use Otus\Hw16\Application\Service\OrderService;
use Otus\Hw16\Domain\Builder\BurgerBuilder;
use Otus\Hw16\Domain\Builder\HotDogBuilder;
use Otus\Hw16\Domain\Builder\SandwichBuilder;

class OrderFoodItemUseCase
{
    public function __construct(
        private OrderService $orderService,
        private BurgerBuilder $burgerBuilder,
        private HotDogBuilder $hotDogBuilder,
        private SandwichBuilder $sandwichBuilder
    ) {
    }

    public function __invoke(OrderFoodItemRequest $request): array
    {
        $type = $request->getType();
        $customIngredients = $request->getCustomIngredients();

        $builder = match ($type) {
            'burger' => $this->burgerBuilder,
            'hotdog' => $this->hotDogBuilder,
            'sandwich' => $this->sandwichBuilder,
            default => throw new \InvalidArgumentException("Unknown food type: $type"),
        };

        $id = $this->orderService->orderFoodItem($builder, $customIngredients);
        return [
            'id' => $id,
            'type' => $type,
            'ingredients' => array_merge($builder->getProduct()->getIngredients(), $customIngredients),
        ];
    }
}
