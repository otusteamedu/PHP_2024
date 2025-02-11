<?php

namespace App\Service;

use App\App;
use App\Model\Event;
use App\Storage\Storage;

class EventService implements Service
{
    private Storage $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function addEvent(array $event): Event
    {
        $event = Event::create($event);
        $this->storage->addEvent($event);

        return $event;
    }

    public function getBestEvent(array $conditions): ?Event
    {
        return $this->storage->getBestEvent($conditions);
    }

    public function deleteAll(): void
    {
        $this->storage->deleteAll();
    }

    public function migrate(): void
    {
        $data = App::seedData();
        $events = Event::createArray($data);

        $this->storage->migrate($events);
    }
}