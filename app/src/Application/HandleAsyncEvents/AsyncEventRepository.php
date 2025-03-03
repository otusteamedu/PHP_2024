<?php

namespace AnatolyShilyaev\App\Application\HandleAsyncEvents;

interface AsyncEventRepository
{
    public function listenAsyncEvents(callable $callback): void;
}
