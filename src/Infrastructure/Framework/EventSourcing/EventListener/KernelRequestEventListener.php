<?php

declare(strict_types=1);

namespace App\Infrastructure\Framework\EventSourcing\EventListener;

use App\Application\EventSourcing\IEventListener;
use App\Application\EventSourcing\IEventPublisher;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class KernelRequestEventListener
{
    public function __construct(
        private readonly IEventPublisher $eventManager,
        /**
         * @var IEventListener[]
         */
        private readonly iterable $listeners,

    ) {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        foreach ($this->listeners as $listener) {
            $this->eventManager->subscribe($listener->getSubscribedEventName(), $listener);
        }
    }
}
