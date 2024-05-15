<?php

namespace App\Infrastructure\Main;

use App\Infrastructure\Enums\RequestMethodEnum;

final readonly class Request
{
    private string $uri;
    protected ?string $method;
    protected ?string $controller;
    protected ?string $action;
    protected ?string $params;

    private const URL_PATTERN = "#(?P<controller>\w+(-[A-z-]+)*)[/]?(?P<action>[A-z-]+)?[/]?[?]?(?P<params>.*)#ui";

    public function __construct()
    {
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->parseRequest();
    }

    public function getController(): ?string
    {
        return $this->controller;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function get($key): ?string
    {
        $requestData = RequestMethodEnum::tryFrom($this->method)?->getData();

        return $requestData['$key'] ?? null;
    }

    public function getAll(): array
    {
        return RequestMethodEnum::tryFrom($this->method)?->getData();
    }

    protected function parseRequest(): void
    {
        if (preg_match_all(self::URL_PATTERN, $this->uri, $matches)) {
            $this->controller = preg_replace_callback(
                '/((-)(\w))/',
                static fn($matches) => strtoupper($matches[2]),
                $matches['controller'][0]
            );
            $this->action = $matches['action'][0];
            $this->params = $matches['params'][0] == '' ? null : $matches['params'][0];
        }
    }
}
