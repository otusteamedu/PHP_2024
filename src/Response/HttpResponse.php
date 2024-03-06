<?php

declare(strict_types=1);

namespace App\Response;

readonly class HttpResponse implements ResponseInterface
{
    public function __construct(private string $content)
    {
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
