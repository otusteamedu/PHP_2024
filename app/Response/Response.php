<?php

declare(strict_types=1);

namespace App\Response;

class Response
{
    public function __construct(readonly string $content)
    {
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
