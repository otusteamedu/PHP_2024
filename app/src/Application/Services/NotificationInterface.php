<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Domain\Entity\BankStatementData;

interface NotificationInterface
{
    public function send(BankStatementData $data);
}
