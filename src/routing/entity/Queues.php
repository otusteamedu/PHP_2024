<?php

declare(strict_types=1);

namespace app\routing\entity;

enum Queues: string
{
    case ExecuteTasks = 'execute_tasks';

    public function queuesName(): string
    {
        return $this->value . '_queues';
    }

    public function consumersName(): string
    {
        return $this->value . '_consumers';
    }

    public static function getConsumerNameByQueuesName(string $name): string
    {
        return str_replace('_queues', '', $name) . '_consumers';
    }

    /**
     * @codeCoverageIgnore
     */
    public static function getQueueByConsumerName(string $consumerName): self
    {
        $name = str_replace('_consumers', '', $consumerName);
        return self::from($name);
    }
}
