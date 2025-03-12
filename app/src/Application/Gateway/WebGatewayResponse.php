<?php

declare(strict_types=1);

namespace PavelMiasnov\MediaMonitoring\Application\Gateway;

class WebGatewayResponse
{
    private string $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
