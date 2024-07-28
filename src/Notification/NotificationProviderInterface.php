<?php

declare(strict_types=1);

namespace App\Notification;

use App\Message\SendFinanceReportMessage;

interface NotificationProviderInterface
{
    public function sendFinanceReport(SendFinanceReportMessage $message);
}
