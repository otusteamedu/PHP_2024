<?php

declare(strict_types=1);

namespace Viking311\Analytics\Command;

use Viking311\Analytics\Http\Request\Request;
use Viking311\Analytics\Http\Response\Response;

interface CommandInterface
{
    /**
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function run(Request $request, Response $response): void;
}
