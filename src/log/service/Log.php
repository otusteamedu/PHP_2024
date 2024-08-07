<?php

declare(strict_types=1);

namespace app\log\service;

use yii\log\Logger;

/**
 * @codeCoverageIgnore
 */
class Log
{
    public function __construct(
        private readonly Logger $logger
    )
    {
    }

    public function error($message, $category = 'offer-log'): void
    {
        $this->logger->log($message, Logger::LEVEL_ERROR, $category);
    }

    public function warning($message, $category = 'offer-log'): void
    {
        $this->logger->log($message, Logger::LEVEL_WARNING, $category);
    }

    public function info($message, $category = 'offer-log'): void
    {
        $this->logger->log($message, Logger::LEVEL_INFO, $category);
    }
}
