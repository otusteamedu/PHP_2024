<?php

declare(strict_types=1);

namespace App\Message;

class SendFinanceReportMessage
{
    public function __construct(public string $email, public string $content)
    {
    }
}
