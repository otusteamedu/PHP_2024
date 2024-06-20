<?php

declare(strict_types=1);

namespace Alogachev\Homework\Infrastructure\Command;

use Alogachev\Homework\Application\Messaging\Consumer\ConsumerInterface;

class GenerateBankStatementCommend
{
    public function __construct(
        private readonly ConsumerInterface $consumer
    ) {
    }

    public function execute(): void
    {
        $this->consumer->consume();
    }
}
