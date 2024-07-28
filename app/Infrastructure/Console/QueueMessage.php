<?php

namespace App\Infrastructure\Console;

use App\Domain\Contract\QueueMessageInterface;
use PhpAmqpLib\Message\AMQPMessage;

class QueueMessage extends AMQPMessage implements QueueMessageInterface
{
}
