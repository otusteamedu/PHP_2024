<?php

declare(strict_types=1);

namespace Alogachev\Homework\Application\Messaging\Producer;

use Alogachev\Homework\Application\Messaging\Message\QueueMessageInterface;

interface ProducerInterface
{
    public function sendMessage(QueueMessageInterface $message): void;
}
