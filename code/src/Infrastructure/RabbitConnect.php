<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw19\Infrastructure;

use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitConnect
{
    const QUEUE_NAME = 'queue_default';

    private $channel;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $connection = new AMQPStreamConnection('rabbit-mq', 5672, 'guest', 'guest');
        $this->channel = $connection->channel();
        $this->channel->queue_declare(self::QUEUE_NAME, false, true, false, false);
    }

    public function sengMsgToQueue($body)
    {
        $msg = new AMQPMessage($body);
        $this->channel->basic_publish($msg, '', self::QUEUE_NAME);
    }

    public function getMsqFromQueue($queueName): ?string
    {
        $msq = $this->channel->basic_get($queueName, true);
        return $msq ? $msq->getBody() : null;
    }

}