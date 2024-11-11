<?php

namespace App\Handlers;

use App\Contracts\QueueTaskHandlerInterface;

class NotificationTaskHandler implements QueueTaskHandlerInterface
{
    public function handle($data): void
    {
        echo "Processing Notification: " . json_encode($data) . PHP_EOL;
    }
}