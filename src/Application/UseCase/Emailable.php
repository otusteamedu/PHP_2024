<?php

declare(strict_types=1);

namespace Pozys\BankStatement\Application\UseCase;

use Pozys\BankStatement\Application\DTO\Email;

interface Emailable
{
    public function send(Email $email): bool;
}
