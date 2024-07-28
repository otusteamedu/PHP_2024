<?php

declare(strict_types=1);

namespace App\Notification;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use \App\Message\SendFinanceReportMessage;
readonly class MailNotificationProvider implements NotificationProviderInterface
{

    public function __construct(private MailerInterface $mailer)
    {
    }

    public function sendFinanceReport(SendFinanceReportMessage $message)
    {
        $email = (new Email())
            ->from($_ENV['MAILER_FROM'])
            ->to($message->email)
            ->subject('Отчёт')
            ->text($message->content);
        $this->mailer->send($email);
    }
}
