<?php

declare(strict_types=1);

namespace PavelMiasnov\MediaMonitoring\Infrastructure\Gateway;

use PavelMiasnov\MediaMonitoring\Application\Gateway\WebGatewayInterface;
use PavelMiasnov\MediaMonitoring\Application\Gateway\WebGatewayRequest;
use PavelMiasnov\MediaMonitoring\Application\Gateway\WebGatewayResponse;

class WebGateway implements WebGatewayInterface
{
    public function sendRequest(WebGatewayRequest $request): WebGatewayResponse
    {
        $url = $request->getUrl();
        $content = file_get_contents($url);

        if ($content === false) {
            throw new \RuntimeException('Failed to fetch content from URL: ' . $url);
        }

        return new WebGatewayResponse($content);
    }
}
