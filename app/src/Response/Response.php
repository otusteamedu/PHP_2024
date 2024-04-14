<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Redis\Response;

readonly class Response implements ResponseInterface
{
    public function __construct(private string $content)
    {
    }

    public function showResponse(): void
    {
        echo $this->content . PHP_EOL;
    }
}
