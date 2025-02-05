<?php

namespace App\Controller\Amqp\ChatUpdate;

class Message
{
    public function __construct(
        public readonly string $data,
    ) {
    }
}
