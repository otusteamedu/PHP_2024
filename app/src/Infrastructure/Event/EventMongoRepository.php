<?php

namespace Aware\App\Infrastructure\Event;

use Aware\App\Domain\Event\Event;
use Aware\App\Domain\Event\EventRepositoryInterface;
use Aware\App\Infrastructure\Mongo\MongoClient;

class EventMongoRepository implements EventRepositoryInterface
{
    private MongoClient $mongoClient;
    public function __construct()
    {
        $this->mongoClient = new MongoClient(
            $_ENV['MONGODB_URI'],
            $_ENV['MONGODB_DATABASE'],
            $_ENV['MONGODB_EVENTS_COLLECTION']
        );
    }

    public function addEvent(Event $event): void
    {
        $data = [
            'priority' => $event->priority,
            'conditions' => $event->conditions,
            'event' => $event->event,
        ];

        $this->mongoClient->save($data);
    }

    public function getBestEvent(array $conditions): Event
    {
        // TODO: Implement getBestEvent() method.
    }

    public function deleteEvents(): void
    {
        // TODO: Implement deleteEvents() method.
    }

    public function migrate(EventRedisRepository $eventRepository): void
    {
        // TODO: Implement migrate() method.
    }
}
