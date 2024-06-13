<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\Service\ParseUrl;

class ParseUrlResult
{
    public function __construct(readonly private string $title)
    {
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
