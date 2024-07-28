<?php

declare(strict_types=1);

namespace App\Notification;

use App\Queue\Message\SendFinanceReportQueueMessage;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class MailNotificationProvider implements NotificationProviderInterface
{

    public function __construct(private MailerInterface $mailer)
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendFinanceReport(SendFinanceReportQueueMessage $message): void
    {
        $email = (new Email())
            ->from($_ENV['MAILER_FROM'])
            ->to($message->email)
            ->subject('Отчёт')
            ->text($message->content);
        $this->mailer->send($email);
    }
}
