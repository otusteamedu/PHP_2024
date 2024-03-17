<?php

namespace Otus\Handler;

use Otus\Controller\BracketController;
use Otus\Validation\BracketValidator;

class RequestHandler
{
    public function __construct()
    {
    }

    public function handleRequest(): void
    {
        $validator = new BracketValidator();
        $controller = new BracketController($validator);
        $controller->handleRequest();
    }
}