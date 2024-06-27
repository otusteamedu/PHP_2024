<?php

namespace App\Infrastructure\CustomerTask;

use App\Domain\CustomerTask\Task;
use PhpAmqpLib\Message\AMQPMessage;

class QueueMessage
{
    private $msg;

    public function __construct(Task $task)
    {
        $this->msg = new AMQPMessage(json_encode($task->jsonSerialize()));
    }

    public function getValue(): AMQPMessage
    {
        return $this->msg;
    }
}
