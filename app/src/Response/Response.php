<?php

declare(strict_types=1);

namespace AlexanderPogorelov\ElasticSearch\Response;

readonly class Response implements ResponseInterface
{
    public function __construct(private string|array $content)
    {
    }

    public function showResponse(): void
    {
        if (is_array($this->content)) {
            var_dump($this->content);
            exit;
        }

        echo $this->content . PHP_EOL;
    }
}
