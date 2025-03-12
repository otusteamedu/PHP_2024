<?php

declare(strict_types=1);

namespace PavelMiasnov\MediaMonitoring\Application\UseCase\CreateNews;

class CreateNewsRequest
{
    public function __construct(public readonly string $url)
    {
    }
}
