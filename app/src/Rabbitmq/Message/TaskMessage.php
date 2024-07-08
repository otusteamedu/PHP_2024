<?php

declare(strict_types=1);

namespace App\Rabbitmq\Message;

use App\Entity\Task;

readonly class TaskMessage implements \JsonSerializable, MessageInterface
{
    public function __construct(
        public int $id,
    ) {
    }

    public static function creteFromTask(Task $task): self
    {
        return new self(
            $task->getId(),
        );
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'className' => $this->getMessageClass(),
        ];
    }

    public function getMessageClass(): string
    {
        return static::class;
    }
}
