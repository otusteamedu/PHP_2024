<?php

namespace Src\Domain\Interface;

interface PublisherInterface
{
    public function sendMessageToChannel(string $queue_name, string $message): void;
}
