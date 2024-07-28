<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\SendFinanceReportMessage;
use App\Notification\NotificationProviderInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Email;

#[AsMessageHandler]
readonly class SendReportHandler
{
    public function __construct(private NotificationProviderInterface $notificationProvider)
    {
    }

    public function __invoke(SendFinanceReportMessage $message): void
    {
        $this->notificationProvider->sendFinanceReport($message);
    }
}
