<?php

declare(strict_types=1);

namespace AnatolyShilyaev\App;

class Pattern
{
    private string $pattern;

    public function __construct()
    {
        $this->pattern = "/\b[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}\b/";
    }

    public function getPattern(): string
    {
        return $this->pattern;
    }
}
