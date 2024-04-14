<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Application\UseCase\Order;

use RailMukhametshin\Hw\Application\UseCase\Request\SetOrderRatingRequest;
use RailMukhametshin\Hw\Domain\Notifications\OrderNotificationInterface;
use RailMukhametshin\Hw\Domain\Repository\OrderRepositoryInterface;
use RailMukhametshin\Hw\Domain\ValueObject\Rating;

class SetOrderRatingUseCase
{
    private OrderRepositoryInterface $orderRepository;
    private OrderNotificationInterface $orderNotification;
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        OrderNotificationInterface $orderNotification
    )
    {
        $this->orderRepository = $orderRepository;
        $this->orderNotification = $orderNotification;
    }

    public function __invoke(SetOrderRatingRequest $request): void
    {
        $order = $this->orderRepository->findById($request->id);
        $order->setRating(new Rating($request->rating));
        $this->orderRepository->save($order);

        $this->orderNotification->notifyAboutSetRating($order);
    }
}
