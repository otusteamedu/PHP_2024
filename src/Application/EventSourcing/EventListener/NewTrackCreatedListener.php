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
        $subscription = $this->subscriptionRepository->findUserSubscriptionByGenre(
            new FindUserByGenreSubscriptionDto($event->user, $event->genre)
        );

        if (!is_null($subscription)) {
            // TODO: Отправляем сообщение что вышел новый трек нужного жанра.
        }
    }

    public function getSubscribedEventName(): string
    {
        return NewTrackCreatedEvent::class;
    }
}
