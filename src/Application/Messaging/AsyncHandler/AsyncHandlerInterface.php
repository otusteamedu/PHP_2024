<?php

declare(strict_types=1);

namespace Alogachev\Homework\Application\Messaging\AsyncHandler;

use Alogachev\Homework\Application\Messaging\Message\QueueMessageInterface;

interface AsyncHandlerInterface
{
    public function handle(QueueMessageInterface $message): void;
}
