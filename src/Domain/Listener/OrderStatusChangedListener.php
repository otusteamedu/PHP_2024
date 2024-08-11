<?php

declare(strict_types=1);

namespace App\Domain\Listener;

use App\Domain\Enum\OrderStatuses;
use App\Domain\Interface\{EventInterface, ListenerInterface, NotifierInterface};

class OrderStatusChangedListener implements ListenerInterface
{
    private array $notifiableStatuses = [
        OrderStatuses::Cooking,
        OrderStatuses::Cooked,
        OrderStatuses::ForPickup,
    ];

    public function __construct(private readonly NotifierInterface $notifier) {}

    public function handle(EventInterface $event): void
    {
        if (!in_array($event->getPayload(), $this->notifiableStatuses)) {
            return;
        }

        $this->notifier->notify([
            'order' => $event->getSource()->getId(),
            'status' => $event->getPayload(),
        ]);
    }
}
