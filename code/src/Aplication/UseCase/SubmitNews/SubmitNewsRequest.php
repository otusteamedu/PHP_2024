<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw14\Aplication\UseCase\SubmitNews;

class SubmitNewsRequest
{
    public readonly string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }
}