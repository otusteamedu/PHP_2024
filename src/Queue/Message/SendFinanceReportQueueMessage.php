<?php

declare(strict_types=1);

namespace App\Queue\Message;

class SendFinanceReportQueueMessage extends AbstractQueueMessage
{
    public const QUEUE_NAME = 'app:report:finance:send';

    public string $email;
    public string $content;
    public function __construct(string $email, string $content)
    {
        parent::__construct();
        $this->email = $email;
        $this->content = $content;
    }
}
