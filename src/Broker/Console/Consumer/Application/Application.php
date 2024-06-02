<?php

declare(strict_types=1);

namespace AlexanderGladkov\Broker\Console\Consumer\Application;

use AlexanderGladkov\Broker\Config\Config;
use AlexanderGladkov\Broker\Console\Consumer\Service\MessageConsume\MessageConsumeService;

class Application
{
    public function run():void
    {
        (new MessageConsumeService(new Config()))->startConsume();
    }
}
