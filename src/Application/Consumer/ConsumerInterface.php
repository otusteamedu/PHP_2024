<?php

namespace SergeyShirykalov\HomeworkRabbit\Application\Consumer;

interface ConsumerInterface
{
    public function listenToQueue(callable $callback): void;

}