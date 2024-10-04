<?php

declare(strict_types=1);

namespace Viking311\Queue\Infrastructure;

use Viking311\Queue\Infrastructure\Http\Request;
use Viking311\Queue\Infrastructure\Http\Response;

class Application
{
    public function run(): Response
    {
        $request = new Request();
        $response = new Response();

        if ($request->getUri() != '/') {
            $response->setResultCode(404);
            $response->setContent('Page not found');
            return $response;
        }

        if ($request->getMethod() != 'POST') {
            $response->setResultCode(400);
            $response->setContent('Method not allowed');
            return $response;
        }



        $response->setContent('Ваш запрос обрабатывается');

        return $response;
    }
}
