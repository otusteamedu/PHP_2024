<?php

namespace Ekonyaeva\Otus;

use MongoDB;
use Ekonyaeva\Otus\EventStoreInterface;

class MongoEvent implements EventStoreInterface
{
    const DB = 'myDb';
    private $mongo;
    private $client;

    public function __construct() {
        $this->client = new MongoDB\Client("mongodb://root:123456@mongo:27017");
    }

    public function add($param)
    {
        $db = $this->client->selectDatabase(self::DB);

        $collection = $db->selectCollection($param['event']);
        if (!$collection) {
            $collection = $db->createCollection($param['event']);
            $collection->createIndex(['event' => 1], ['unique' => true]);
        }
        $res = $collection->insertOne([
            'score' => $param['conditions'],
            'event' => $param['event']
        ]);

        return $res->getInsertedCount();
    }

    public function clear(): void
    {
        $this->client->drop();
    }

    public function delete($param): bool | int
    {
        $db = $this->client->selectDatabase(self::DB);
        $res = $db->dropCollection($param['event']);

        return (int) $res->ok;
    }

    public function get($param): array | null
    {
        $data = [];
        $db = $this->client->selectDatabase(self::DB);
        $col = $db->selectCollection($param['event']);
        foreach ($col->find([], ['sort' => ['score' => -1]]) as $doc) {
            $data[$doc->event] = $doc->score;
        }
        return $data;
    }
}