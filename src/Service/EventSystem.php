<?php

namespace KRudenko\Otus\Service;

use KRudenko\Otus\Service\Storage\StorageInterface;

class EventSystem
{
    private StorageInterface $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function addEvent(array $event): int
    {
        return $this->storage->addEvent($event);
    }

    public function clearEvents(): void
    {
        $this->storage->clearEvents();
    }

    public function findBestEvent(array $requestParams): ?array
    {
        foreach ($this->storage->getAllEventsSortedByPriority() as $id) {
            $eventData = $this->storage->getEventData($id);

            if ($this->conditionsMet($eventData['conditions'], $requestParams)) {
                return [
                    'event' => $eventData['event'],
                    'priority' => $eventData['priority']
                ];
            }
        }
        return null;
    }

    private function conditionsMet(array $eventConditions, array $requestParams): bool
    {
        foreach ($eventConditions as $param => $value) {
            if (!isset($requestParams[$param]) || (string)$requestParams[$param] !== (string)$value) {
                return false;
            }
        }
        return true;
    }
}
