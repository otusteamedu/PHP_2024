<?php

declare(strict_types=1);

namespace AlexanderGladkov\Bookshop\Application\Action;

class Response
{
    public function __construct(private readonly string $content)
    {
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
}
