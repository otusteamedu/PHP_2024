<?php

declare(strict_types=1);

namespace App\Base;

readonly class Response
{
    public function __construct(private string $content, private int $statusCode)
    {
        header('HTTP/1.1 ' . $this->statusCode);
    }

    public function __toString(): string
    {
        return $this->content;
    }
}
