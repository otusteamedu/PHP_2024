<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\Dto\Order;
use App\Dto\OrderProduct;
use App\Enum\AdditionIngredientEnum;
use App\Enum\ProductTypeEnum;
use App\UseCase\ExecuteOrderUseCase;
use Psr\Container\ContainerInterface;

/** @var ContainerInterface $container */
$container = require __DIR__ . '/container.php';

$products = [
    new OrderProduct(
        ProductTypeEnum::BURGER,
        2,
        [AdditionIngredientEnum::PEPPER, AdditionIngredientEnum::SALAD]
    ),
    new OrderProduct(
        ProductTypeEnum::SANDWICH,
        1,
        [AdditionIngredientEnum::PEPPER]
    ),
    new OrderProduct(
        ProductTypeEnum::HOTDOG,
        1,
        []
    ),
];

$order = new Order($products);

$useCase = $container->get(ExecuteOrderUseCase::class);

$useCase($order);
