<?php

declare(strict_types=1);

namespace Common;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class MailerWrapper
{
    private Mailer $mailer;
    private string $user;

    public function __construct()
    {
        $this->user = getenv('SMTP_USER');
        $pass = getenv('SMTP_PASS');
        $server = getenv('SMTP_SERVER');
        $port = (int)getenv('SMTP_PORT');
        $dsn = "smtp://" . $this->user . ":" . $pass . "@" . $server . ":" . $port;
        $transport = Transport::fromDsn($dsn);
        $this->mailer = new Mailer($transport);
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