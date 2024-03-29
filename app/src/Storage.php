<?php

namespace Kagirova\Hw15;

interface Storage
{
    public function set(Event $event): void;
    public function get($options): ?Event;
    public function clear(): void;
}