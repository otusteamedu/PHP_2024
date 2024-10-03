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

        return new Response();
    }
}
