<?php

declare(strict_types=1);

namespace App\Command;

use App\Queue\Handler\RequestProcessHandler;
use App\Queue\Message\RequestProcessQueueMessage;
use App\Queue\QueueInterface;
use PhpAmqpLib\Message\AMQPMessage;

class RequestProcessCommand implements CommandInterface
{
    private QueueInterface $queue;
    private RequestProcessHandler $handler;
    public function __construct(QueueInterface $queue, RequestProcessHandler $handler)
    {
        $this->queue = $queue;
        $this->handler = $handler;
    }

    public function execute(): void
    {
        $handler = $this->handler;
        $this->queue->pull(
            RequestProcessQueueMessage::QUEUE_NAME,
            static function (AMQPMessage $msg) use ($handler): void {
                $data = json_decode($msg->getBody(), true);
                $handler(new RequestProcessQueueMessage($data['request_id']));
            }
        );
    }
}
