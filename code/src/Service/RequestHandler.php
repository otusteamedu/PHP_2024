<?php

namespace KRudenko\Otus\Service;

use KRudenko\Otus\Controller\IndexController;

readonly class RequestHandler
{
    private IndexController $controller;

    public function __construct()
    {

        $this->controller = new IndexController();
    }

    public function handle(): string
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        return match ($requestUri) {
            '/string' => $this->controller->handleStringRequest(),
            '/session' => $this->controller->handleSessionRequest(),
            '/' => sprintf('Hello from hostname %s!', gethostname()),
            default => 'Доступны только адреса /string и /session',
        };
    }
}
