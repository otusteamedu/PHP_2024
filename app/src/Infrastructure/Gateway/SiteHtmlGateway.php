<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway;

use App\Application\Gateway\SiteGatewayInterface;
use App\Application\Gateway\SiteGatewayRequest;
use App\Application\Gateway\SiteGatewayResponse;

class SiteHtmlGateway implements SiteGatewayInterface
{
    public function getHtml(SiteGatewayRequest $response): SiteGatewayResponse
    {
        $html = file_get_contents($response->url);

        if (!strlen($html)) {
            throw new \DomainException('Error download html site');
        }

        return new SiteGatewayResponse($html);
    }
}
