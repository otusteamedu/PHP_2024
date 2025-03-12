<?php

declare(strict_types=1);

namespace PavelMiasnov\MediaMonitoring\Application\Gateway;

interface WebGatewayInterface
{
    public function sendRequest(WebGatewayRequest $request): WebGatewayResponse;
}
