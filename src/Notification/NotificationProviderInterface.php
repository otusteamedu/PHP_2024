<?php

declare(strict_types=1);

namespace App\Notification;

use App\Queue\Message\SendFinanceReportQueueMessage;

interface NotificationProviderInterface
{
    public function sendFinanceReport(SendFinanceReportQueueMessage $message);
}
