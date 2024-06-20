<?php

declare(strict_types=1);

namespace Orlov\Otus;

use Orlov\Otus\Controller\FormController;
use Orlov\Otus\Render\ErrorRender;

class Route
{
    private const MAP = [
        '/' => 'main',
        '/formHandler' => 'formHandler',
    ];

    public function __construct(private string $url)
    {} //phpcs:ignore

    public function run(): void
    {
        $action = self::MAP[$this->url] ?? null;
        $controller = new FormController();

        if (!$action || !method_exists($controller, $action)) {
            http_response_code(404);
            echo (new ErrorRender())->show();
            return;
        }

        $controller->$action();
    }
}
