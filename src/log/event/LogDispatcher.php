<?php

declare(strict_types=1);

namespace app\log\event;

use app\event\contract\EventLogContract;
use app\log\entity\LogCategories;
use app\log\service\Log;

/**
 * @codeCoverageIgnore
 */
final class LogDispatcher
{
    public function __construct(
        private Log $log
    ) {}

    public function addLogInfo(EventLogContract $eventLog): void
    {
        $this->log->info(
            $eventLog->logParams(),
            LogCategories::Offer->value
        );
    }
}
