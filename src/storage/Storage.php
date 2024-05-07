<?php

namespace Ahar\Hw12\storage;

use Ahar\Hw12\Event;

interface Storage
{
    public function add(string $key, Event $event): void;

    public function get(string $key): array;

    public function clear(string $key): void;
}
