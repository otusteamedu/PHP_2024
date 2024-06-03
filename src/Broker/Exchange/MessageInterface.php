<?php

namespace AlexanderGladkov\Broker\Exchange;

interface MessageInterface
{
    public function getContent(): string;
    public function ack(): void;
    public function nack(): void;
}
