<?php

declare(strict_types=1);

namespace Settings;

use Asyrovatkin\Hw11\Settings\Config;
use Asyrovatkin\Hw11\Storages\MongoDb\MongoDb;
use Asyrovatkin\Hw11\Storages\RedisDb\RedisDb;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function testFetCurrentDb()
    {
        $config = new Config();
        $actual = $config->getCurrentDb();
        $this->assertTrue($actual instanceof MongoDb || $actual instanceof RedisDb);
    }
}