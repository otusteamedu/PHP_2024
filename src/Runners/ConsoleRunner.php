<?php

declare(strict_types=1);

namespace App\runners;

use App\ConnectionCreator;
use App\Consumer;
use App\Dictionaries\QueueDictionary;
use App\Handlers\MessageHandler;

class ConsoleRunner
{
    public function run(): void
    {
        $connection = ConnectionCreator::create();
        $consumer = new Consumer($connection);
        $consumer->consume(QueueDictionary::BankStatementQueue->value, new MessageHandler());
    }
}
