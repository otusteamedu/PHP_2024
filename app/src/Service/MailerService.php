<?php

declare(strict_types=1);

namespace App\Service;

use App\Rabbitmq\Message\BankReportMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function sendEmail(BankReportMessage $message): void
    {
        try {
            $email = (new Email())
                ->from('hello@example.com')
                ->to($message->email)
                ->subject($this->generateSubject($message))
                ->text($this->generateTextMessage($message));

            $this->mailer->send($email);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage(), [ 'exception' => $e ]);
        }
    }

    private function generateTextMessage(BankReportMessage $message): string
    {
        return sprintf('Dear %s! The bank report has been created.', $message->email);
    }

    private function generateSubject(BankReportMessage $message): string
    {
        return sprintf('Bank report %s - %s', $message->startDate, $message->endDate);
    }
}
