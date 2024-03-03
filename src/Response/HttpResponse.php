<?php

declare(strict_types=1);

namespace App\Response;

readonly class HttpResponse implements ResponseInterface
{
    public function __construct(private int $http_code, private string $content)
    {
    }

    public function send(): void
    {
        header('Content-Type: application/json; charset=UTF-8');
        http_response_code($this->http_code);
        echo $this->content;
    }
}
