<?php

declare(strict_types=1);

namespace AlexanderGladkov\Analytics\Application\Action;

class Response
{
    public function __construct(private readonly string $content)
    {
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
