<?php

namespace AKornienko\Php2024\Application\HandleAsyncEvents;

readonly class AsyncEventHandler
{
    const LISTEN_ASYNC_EVENTS_MSG = "Listen async events";

    public function __construct(private AsyncEventRepository $repository)
    {
    }

    public function __invoke(callable $callback): string
    {
        $this->repository->listenAsyncEvents($callback);
        return self::LISTEN_ASYNC_EVENTS_MSG;
    }
}
