<?php

declare(strict_types=1);

namespace AlexanderGladkov\Broker\Service\Logger;

use Monolog\Logger;
use Monolog\Level;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

class LoggerFactory
{
    public function create(): Logger
    {
        $logPath = LOG_DIRECTORY . '/app.log';
        $logger = new Logger('app');
        $logger->pushHandler(new StreamHandler($logPath, Level::Debug));
        $logger->pushHandler(new FirePHPHandler());
        return $logger;
    }
}
