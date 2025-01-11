<?php

namespace Ekonyaeva\Otus;

use Ekonyaeva\Otus\EventStoreInterface;

class EventSystem
{
    private EventStoreInterface $storage;

    public function __construct(EventStoreInterface $storage)
    {
        $this->storage = $storage;
    }

    public function addEvent(array $param)
    {
        $this->storage->add($param);
    }

    public function clearEvents()
    {
        $this->storage->clear();
    }

    public function getEvent($params)
    {
        return $this->storage->get($params);
    }
}