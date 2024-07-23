<?php

namespace App\Domain\Contract;

interface QueueMessageInterface
{
    public function setBody(string $body);
}