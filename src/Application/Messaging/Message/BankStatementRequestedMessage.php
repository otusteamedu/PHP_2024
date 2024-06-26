<?php

declare(strict_types=1);

namespace Alogachev\Homework\Application\Messaging\Message;

readonly class BankStatementRequestedMessage implements QueueMessageInterface
{
    public function __construct(
        public int $id,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
        ];
    }
}
