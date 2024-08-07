<?php

declare(strict_types=1);

namespace app\routing\producers;

use app\routing\entity\PriorityRange;
use app\routing\entity\Queues;
use mikemadisonweb\rabbitmq\events\RabbitMQConsumerEvent;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;
use Yii;

/**
 * @codeCoverageIgnore
 */
class StaticProducer implements ProducerContract
{
    public function publish(array $msg, string $queuesName, array $headers = [], PriorityRange $priority = PriorityRange::MIN): bool
    {
        $build_message = $this->buildMessage($msg, $headers);
        $consumer = Yii::$app->rabbitmq->getConsumer(Queues::getConsumerNameByQueuesName($queuesName));

        $queues = $consumer->getQueues();
        $queue = current($queues);

        Yii::$app->rabbitmq->trigger(
            RabbitMQConsumerEvent::BEFORE_CONSUME,
            new RabbitMQConsumerEvent(
                [
                    'message' => $build_message,
                    'consumer' => $consumer,
                ]
            )
        );

        $queue($build_message);

        Yii::$app->rabbitmq->trigger(
            RabbitMQConsumerEvent::AFTER_CONSUME,
            new RabbitMQConsumerEvent(
                [
                    'message' => $build_message,
                    'consumer' => $consumer,
                ]
            )
        );

        return true;
    }

    private function buildMessage(array $msg, array $headers): AMQPMessage
    {
        $message = new AMQPMessage($msg, []);
        if (!empty($headers)) {
            $headersTable = new AMQPTable($headers);
            $message->set('application_headers', $headersTable);
        }

        return $message;
    }
}
