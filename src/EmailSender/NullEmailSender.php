<?php

declare(strict_types=1);

namespace App\EmailSender;

use App\Entity\Email;

final readonly class NullEmailSender implements EmailSenderInterface
{
    public function send(Email $email): void
    {
        // imitate message sending
        sleep(10);
    }
}
