<?php

namespace Core;

use Controller\RequestHandler;

class App
{

    public function run(): string
    {
        $requestHandler = new RequestHandler();

        return $requestHandler->handle();
    }

}