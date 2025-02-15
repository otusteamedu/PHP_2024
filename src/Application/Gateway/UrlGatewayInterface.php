<?php

namespace App\Application\Gateway;

interface UrlGatewayInterface
{
    public function getTitle(UrlGatewayRequest $request): UrlGatewayResponse;
}
