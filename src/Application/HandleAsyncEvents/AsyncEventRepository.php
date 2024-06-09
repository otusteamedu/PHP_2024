<?php

namespace AKornienko\Php2024\Application\HandleAsyncEvents;

interface AsyncEventRepository
{
    public function listenAsyncEvents(callable $callback): void;
}
