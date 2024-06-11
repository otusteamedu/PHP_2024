<?php

namespace App\Infrastructure\Service\Queue;

interface MessageInterface
{
    public function getContent(): string;
    public function ack(): void;
    public function nack(): void;
}
