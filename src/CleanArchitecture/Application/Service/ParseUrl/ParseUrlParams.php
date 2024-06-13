<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\Service\ParseUrl;

class ParseUrlParams
{
    public function __construct(readonly private string $url)
    {
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
