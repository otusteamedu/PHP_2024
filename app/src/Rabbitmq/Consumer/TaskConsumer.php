<?php

declare(strict_types=1);

namespace App\Rabbitmq\Consumer;

use App\Rabbitmq\Message\TaskMessage;
use App\Service\TaskService;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;

class TaskConsumer implements ConsumerInterface
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly TaskService $service,
    ) {
    }

    public function execute(AMQPMessage $msg): bool|int
    {
        try {
            $data = json_decode($msg->body, true, flags: JSON_THROW_ON_ERROR);

            if ($data['className'] !== TaskMessage::class) {
                $this->logger->error(sprintf('Unsupported message class: %s', $data['className']));

                return false;
            }

            $this->service->completeTask((int) $data['id']);

            return self::MSG_ACK;
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage(), [ 'exception' => $e ]);

            return self::MSG_REJECT;
        }
    }
}
