<?php

declare(strict_types=1);

namespace Common;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

class MailerWrapper
{
    private Mailer $mailer;
    private string $user;

    public function __construct(
        string $user,
        Mailer $mailer
    ) {
        $this->user = $user;
        $this->mailer = $mailer;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function send(string $receiverEmail, string $subject, string $message): void
    {
        $email = new Email();
        $email
            ->from($this->user)
            ->to($receiverEmail)
            ->subject($subject)
            ->text($message);

        $this->mailer->send($email);
    }
}
