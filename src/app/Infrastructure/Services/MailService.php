<?php

declare(strict_types=1);

namespace App\Infrastructure\Services;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class MailService
{
    public function __construct(private MailerInterface $mailer)
    {
        //
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function send(string $to, string $from, string $subject, string $message): void
    {
        $email = (new Email())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->html($message);

        $this->mailer->send($email);
    }
}