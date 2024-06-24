<?php

declare(strict_types=1);

use App\ChainResponsibility\OrderCookingHandler;
use App\ChainResponsibility\OrderHandler;
use App\ChainResponsibility\OrderHandlerInterface;
use App\ChainResponsibility\OrderPaymentHandler;
use App\Observe\CookingStatusObserver;
use App\Observe\CookingStatusSubject;
use App\Observe\SubjectInterface;
use App\UseCase\ExecuteOrderUseCase;
use DI\Container;
use Psr\Container\ContainerInterface;

require_once __DIR__ . '/vendor/autoload.php';

$container = new Container([
    ExecuteOrderUseCase::class => function (ContainerInterface $container) {
        /** @var OrderHandlerInterface $orderPaymentHandler */
        $orderPaymentHandler = $container->get(OrderPaymentHandler::class);
        $orderCookingHandler = $container->get(OrderCookingHandler::class);
        $orderPaymentHandler->setNextHandler($orderCookingHandler);
        $orderHandler = new OrderHandler();
        $orderHandler->setNextHandler($orderPaymentHandler);
        return new ExecuteOrderUseCase($orderHandler);
    },
    CookingStatusSubject::class => function (ContainerInterface $container) {
        /** @var SubjectInterface $subject */
        $subject = new CookingStatusSubject();
        $subject->attach($container->get(CookingStatusObserver::class));
        return $subject;
    }
]);

return $container;
