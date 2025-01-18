<?php

namespace KRudenko\Otus\Core;

use KRudenko\Otus\Service\RequestHandler;

readonly class App
{

    private RequestHandler $handler;

    function __construct()
    {
        $this->handler = new RequestHandler();
    }

    public function run(): string
    {
        $this->startSession();
        return $this->handler->handle();
    }

    public function startSession(): void
    {
        session_start();
    }
}
