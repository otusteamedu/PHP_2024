<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw11\tests\Storages\MongoDb;

use Asyrovatkin\Hw11\Builders\EventBuilder;
use Asyrovatkin\Hw11\Storages\MongoDb\MongoDb;
use MongoDB\Client;
use PHPUnit\Framework\TestCase;

class MongoDbTest extends TestCase
{

    private \MongoDB\Collection $collection;
    protected function setUp(): void
    {
        $client = new Client('mongodb://root:mypass1@mongo:27017');
        $this->collection = $client->hw11->records;
    }

    protected function tearDown(): void
    {
        $this->collection->drop();
    }

    public function testAddEvent()
    {
        $this->addEvent();
        $actual = (int) $this->collection->countDocuments();
        $this->assertEquals(1, $actual);
    }

    public function testClearStorage()
    {
        $this->addEvent();
        $mongoDb = new MongoDb();
        $mongoDb->clearStorage();
        $actual = (int) $this->collection->countDocuments();
        $this->assertEquals(0, $actual);
    }

    /**
     * @dataProvider getEventIdsByParamsWithMaxPriorityDataProvider
     * @return void
     */
    public function testGetEventIdsByParamsWithMaxPriority($testParam, $expectedCount)
    {
        $this->addEvent();
        $mongoDb = new MongoDb();
        $actualCount = count($mongoDb->getEventIdsByParamsWithMaxPriority($testParam));
        $this->assertEquals($expectedCount, $actualCount);
    }

    public static function getEventIdsByParamsWithMaxPriorityDataProvider()
    {
        return [
            [["param1" => 1, "param2" => 2], 1],
            [["param1" => 2, "param2" => 2], 0],
            [["param1" => 1], 1],
            [["param1" => 2], 0],
            [[], 1],
        ];
    }

    /**
     * @return void
     */
    private function addEvent(): void
    {
        $testEventArr = ["priority" => "1000", "conditions" => ["param1" => "1", "param2" => 2], "event" => "eventName"];
        $eventBuilder = new EventBuilder();
        $event = $eventBuilder->build($testEventArr);
        $mongoDb = new MongoDb();
        $mongoDb->addEvent($event);
    }

}