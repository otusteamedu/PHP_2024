<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw11\Settings;

use Asyrovatkin\Hw11\Storages\MongoDb\MongoDb;
use Asyrovatkin\Hw11\Storages\RedisDb\RedisDb;
use Asyrovatkin\Hw11\Storages\Storage;

class Config
{
    public function getCurrentDb(): Storage
    {
        return new MongoDb();
//        return new RedisDb();
    }

}