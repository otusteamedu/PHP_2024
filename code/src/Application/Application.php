<?php

declare(strict_types=1);

namespace Viking311\Analytics\Application;

use Viking311\Analytics\Http\Request\Request;
use Viking311\Analytics\Http\Response\Response;

class Application
{
    public function run(): Response
    {
        $request = new Request();
        $response = new Response();

        switch ($request->getUri()) {
            default:
                $response->setResultCode(404);
                $response->setContent("Page not found");
        }

        return $response;
    }
}

