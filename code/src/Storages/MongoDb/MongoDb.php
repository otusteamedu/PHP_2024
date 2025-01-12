<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw11\Storages\MongoDb;

use Asyrovatkin\Hw11\Models\Event;
use Asyrovatkin\Hw11\Storages\Storage;
use MongoDB\Client;
use MongoDB\Collection;

class MongoDb implements Storage
{

    private Client $client;
    private Collection $collection;

    public function __construct()
    {
        $this->client = new Client('mongodb://root:mypass1@mongo:27017');
        $this->collection = $this->client->hw11->records;
    }

    public function addEvent(Event $event)
    {
        $eventArr = $event->toArray();
        $id = $this->collection->countDocuments();
        $id++;
        $eventArr['id'] = $id;
        $this->collection->insertOne($eventArr);
    }

    public function getEventIdsByParamsWithMaxPriority(array $params): array
    {
        $options = ['sort' => ['priority' => -1]];
        $cursor = $this->collection->find($params, $options);

        $result = [];
        foreach ($cursor as $document) {
            if (isset($priority) && $priority > $document['priority']) break;
            $result[] = $document['event']  . ' for id = ' . $document['id'];
            $priority = $document['priority'];
        }

        return $result;
    }

    public function clearStorage(): void
    {
        $this->collection->drop();
    }
}