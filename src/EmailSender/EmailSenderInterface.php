<?php

declare(strict_types=1);

namespace App\EmailSender;

use App\Entity\Email;
use App\Exception\EmailSenderException;

interface EmailSenderInterface
{
    /**
     * @throws EmailSenderException
     */
    public function send(Email $email): void;
}
