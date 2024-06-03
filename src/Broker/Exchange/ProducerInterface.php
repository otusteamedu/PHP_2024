<?php

namespace AlexanderGladkov\Broker\Exchange;

interface ProducerInterface
{
    public function publish(string $message): void;
}
