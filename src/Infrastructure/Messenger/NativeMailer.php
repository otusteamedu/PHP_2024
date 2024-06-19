<?php

declare(strict_types=1);

namespace Pozys\BankStatement\Infrastructure\Messenger;

use Pozys\BankStatement\Application\DTO\Email;
use Pozys\BankStatement\Application\UseCase\Emailable;

class NativeMailer implements Emailable
{
    public function send(Email $email): bool
    {
        return mail($email->to, $email->subject, $email->message);
    }
}
