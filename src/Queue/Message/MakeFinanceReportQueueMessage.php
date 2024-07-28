<?php

declare(strict_types=1);

namespace App\Queue\Message;

use DateTime;

class MakeFinanceReportQueueMessage extends AbstractQueueMessage
{
    public const QUEUE_NAME = 'app:report:finance:make';

    public string $email;
    public DateTime $from;
    public DateTime $to;
    public function __construct(string $email, DateTime $from, DateTime $to)
    {
        parent::__construct();
        $this->email = $email;
        $this->from = $from;
        $this->to = $to;
    }

    public function jsonSerialize(): array
    {
        return [
            'email' => $this->email,
            'from' => $this->from->format('Y-m-d'),
            'to' => $this->to->format('Y-m-d')
        ];
    }
}
