<?php

namespace App\Application\Gateway\ParserUrl;

class ParserUrlGatewayRequest
{
    /**
     * @param string $url
     */
    public function __construct(public string $url)
    {
    }
}
