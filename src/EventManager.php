<?php

namespace Src;

class EventManager {
    private $storage;

    public function __construct(StorageInterface $storage) {
        $this->storage = $storage;
    }

    public function addEvent($priority, $conditions, $event) {
        $this->storage->addEvent($priority, $conditions, $event);
    }

    public function clearEvents() {
        $this->storage->clearEvents();
    }

    public function getBestEvent($params) {
        return $this->storage->getBestEvent($params);
    }
}
