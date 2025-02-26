<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw11\tests\Storages\RedisDb;

use Asyrovatkin\Hw11\Builders\EventBuilder;
use Asyrovatkin\Hw11\Storages\RedisDb\RedisDb;
use PHPUnit\Framework\TestCase;
use Predis\Client;

class RedisDbTest extends TestCase
{
    private Client $client;
    protected function setUp(): void
    {
        $this->client  = new Client('tcp://redis:6379');;
        $this->client->connect();
    }

    protected function tearDown(): void
    {
        $this->client->flushall();
    }

    public function testAddEvent()
    {
        $this->addEvent();
        $actual = (int) $this->client->keys('*');
        $this->assertEquals(1, $actual);
    }

    public function testClearStorage()
    {
        $this->addEvent();
        $redisDb = new RedisDb();
        $redisDb->clearStorage();
        $actual = (int) $this->client->keys('*');
        $this->assertEquals(0, $actual);
    }

    /**
     * @dataProvider getEventIdsByParamsWithMaxPriorityDataProvider
     * @return void
     */
    public function testGetEventIdsByParamsWithMaxPriority($testParam, $expectedCount)
    {
        $this->addEvent();
        $redisDb = new RedisDb();
        $actualCount = count($redisDb->getEventIdsByParamsWithMaxPriority($testParam));
        $this->assertEquals($expectedCount, $actualCount);
    }

    public static function getEventIdsByParamsWithMaxPriorityDataProvider(): array
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
        $redisDb = new RedisDb();
        $redisDb->addEvent($event);
    }
}