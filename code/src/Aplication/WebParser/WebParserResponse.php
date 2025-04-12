<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw14\Aplication\WebParser;

class WebParserResponse
{
    private readonly string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}