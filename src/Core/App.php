<?php

namespace Ali\Core;

use Ali\Controller\RequestHandler;

class App
{

    public function run(): string
    {
        $requestHandler = new RequestHandler();

        return $requestHandler->handle();
    }

}