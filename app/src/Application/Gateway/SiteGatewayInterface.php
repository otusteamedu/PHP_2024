<?php

declare(strict_types=1);

namespace App\Application\Gateway;

interface SiteGatewayInterface
{
    public function getHtml(SiteGatewayRequest $request): SiteGatewayResponse;
}
