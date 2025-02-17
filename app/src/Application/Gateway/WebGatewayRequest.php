<?php

declare(strict_types=1);

namespace PavelMiasnov\MediaMonitoring\Application\Gateway;

class WebGatewayRequest
{
    private string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
