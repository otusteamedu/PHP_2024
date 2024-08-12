<?php

declare(strict_types=1);

namespace App\Queue\Message;

class RequestProcessQueueMessage extends AbstractQueueMessage
{
    public const QUEUE_NAME = 'app:request:process';

    public int $requestId;
    public function __construct(int $requestId)
    {
        parent::__construct();
        $this->requestId = $requestId;
    }

    public function jsonSerialize(): array
    {
        return [
            'request_id' => $this->requestId
        ];
    }
}