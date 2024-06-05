<?php

declare(strict_types=1);

namespace Module\News\Application\Service\Interface;

use Module\News\Application\Service\Dto\Message;

interface MessageBusServiceInterface
{
    public function publish(Message $message): void;
}
