<?php

namespace App\Application\Gateway\ParserUrl;

interface ParserUrlGatewayInterface
{
    public function getTitle(ParserUrlGatewayRequest $request): ParserUrlGatewayResponse;

}
