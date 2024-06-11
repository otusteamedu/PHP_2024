<?php

declare(strict_types=1);

namespace App\Application\EventSourcing\EventListener;

use App\Application\EventSourcing\IEventListener;
use App\Application\Repository\DTO\FindUserByGenreSubscriptionDto;
use App\Domain\Event\NewTrackCreatedEvent;
use App\Domain\Repository\IUserGenreSubscriptionRepository;

class NewTrackCreatedListener implements IEventListener
{
    public function __construct(
        private readonly IUserGenreSubscriptionRepository $subscriptionRepository,
    ) {
    }

    /**
     * @param NewTrackCreatedEvent $event
     */
    public function execute(object $event): void
    {
        $subscriptions = $this->subscriptionRepository->findUsersSubscribedToGenre(
            new FindUserByGenreSubscriptionDto($event->genre)
        );

        if ($subscriptions !== []) {
            foreach ($subscriptions as $subscription) {
                // TODO: Отправляем сообщения всем подписчикам жанра, что вышел новый трек.
            }
        }
    }

    public function getSubscribedEventName(): string
    {
        return NewTrackCreatedEvent::class;
    }
}
