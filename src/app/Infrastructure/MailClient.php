<?php

namespace App\Infrastructure;

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;

class MailClient
{
    private Transport\TransportInterface $transport;

    public function __construct(array $config)
    {
        $this->transport = Transport::fromDsn($config['dsn']);
    }

    public function getMailer(): Mailer
    {
        return new Mailer($this->transport);
    }
}
