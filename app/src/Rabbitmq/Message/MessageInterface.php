<?php

declare(strict_types=1);

namespace App\Rabbitmq\Message;

interface MessageInterface
{
    public function getMessageClass(): string;
}
