<?php

namespace Ahor\Hw19;

use Ahor\Hw19\queues\Queues;
use Ahor\Hw19\handler\GenerateReport;
use Ahor\Hw19\rabbit\Config;
use Ahor\Hw19\rabbit\ConnectFactory;
use Ahor\Hw19\rabbit\Consumer;

class AppConsole
{

    public function run(string $queuesName): void
    {
        $queues = Queues::from($queuesName);
        $handler = match ($queues) {
            Queues::GenerateReport => new GenerateReport(),
        };
        $connection = ConnectFactory::create(Config::build());
        $consumer = new Consumer($connection);
        $consumer->consume($queues->value, $handler);
    }
}
