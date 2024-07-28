<?php

declare(strict_types=1);

namespace App\Message;

class MakeFinanceReportMessage
{
    public function __construct(public string $email, public \DateTime $from, public \DateTime $to)
    {
    }
}
