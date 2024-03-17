<?php

namespace Otus;

use Otus\Handler\RequestHandler;

class Application
{
    public function run(): void
    {
        $requestHandler = new RequestHandler();
        $requestHandler->handleRequest();
    }
}