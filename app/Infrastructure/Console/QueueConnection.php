<?php

declare(strict_types=1);

namespace App\Infrastructure\Console;

use App\Domain\Contract\QueueConnectionInterface;
use Exception;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

final class QueueConnection implements QueueConnectionInterface
{

    /**
     * @throws Exception
     */
    public function __construct(private ?AMQPStreamConnection $connection = null)
    {
        $this->connection = new AMQPStreamConnection(
            env('RABBIT_HOST'),
            env('RABBIT_PORT'),
            env('RABBIT_USERNAME'),
            env('RABBIT_PASSWORD')
        );
    }

    public function channel(): AMQPChannel
    {
        return $this->connection->channel();
    }
}
