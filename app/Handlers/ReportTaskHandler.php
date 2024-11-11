<?php

namespace App\Handlers;

use App\Contracts\QueueTaskHandlerInterface;

class ReportTaskHandler implements QueueTaskHandlerInterface
{
    public function handle($data): void
    {
        echo "Processing Report: " . json_encode($data) . PHP_EOL;
    }
}