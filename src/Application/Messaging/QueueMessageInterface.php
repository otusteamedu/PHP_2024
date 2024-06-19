<?php

declare(strict_types=1);

namespace Alogachev\Homework\Application\Messaging;

interface QueueMessageInterface
{
    public function toArray(): array;
}
