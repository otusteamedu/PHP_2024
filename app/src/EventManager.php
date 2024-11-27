<?php

namespace App;

use App\Storage\StorageInterface;

class EventManager
{
    private StorageInterface $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function addEvent($event): string
    {
        $id = uniqid();
        $this->storage->save("event:$id", $event);
        return "Event added with ID: $id\n";
    }

    public function clearEvents(): string
    {
        $this->storage->clear("event:*");
        return "All events cleared.\n";
    }

    public function findBestEvent($params): string
    {
        $events = $this->storage->getAll("event:*");
        $bestEvent = null;
        foreach ($events as $event) {
            $conditionsMet = true;
            foreach ($event['conditions'] as $condition => $value) {
                if (!isset($params[$condition]) || $params[$condition] != $value) {
                    $conditionsMet = false;
                    break;
                }
            }

            if ($conditionsMet) {
                if (!$bestEvent || $event['priority'] > $bestEvent['priority']) {
                    $bestEvent = $event;
                }
            }
        }

        if ($bestEvent) {
            return "Best event found: " . json_encode($bestEvent) . "\n";
        } else {
            return "No matching event found.\n";
        }
    }


}