<?php

declare(strict_types=1);

namespace App\Queue\Handler;

use App\Notification\NotificationProviderInterface;
use App\Queue\Message\SendFinanceReportQueueMessage;

readonly class SendFinanceReportQueueHandler
{
    public function __construct(private NotificationProviderInterface $notificationProvider)
    {
    }

    public function __invoke(SendFinanceReportQueueMessage $message): void
    {
        $this->notificationProvider->sendFinanceReport($message);
    }
}
