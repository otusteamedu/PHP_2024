<?php

declare(strict_types=1);

namespace app\routing\producers;

use app\routing\entity\PriorityRange;
use mikemadisonweb\rabbitmq\components\Producer;

/**
 * @codeCoverageIgnore
 */
final readonly class Rabbit implements ProducerContract
{
    public function __construct(
        private Producer $producer,
    ) {}

    public function publish(array $msg, string $queuesName, array $headers = [], PriorityRange $priority = PriorityRange::MIN): bool
    {
        $this->producer->publish(
            $msg,
            '',
            $queuesName,
            additionalProperties: ['priority' => $priority->value],
            headers: $headers
        );
        return true;
    }
}
