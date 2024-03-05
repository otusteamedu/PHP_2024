<?php

declare(strict_types=1);

namespace App\Response;

readonly class HttpResponse implements ResponseInterface
{
    public function __construct(private int $http_code, private string $content)
    {
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCode(): int
    {
        return $this->http_code;
    }
}
