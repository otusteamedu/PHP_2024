<?php

namespace App\Application\Gateway;

interface NewsGatewayInterface
{
    public function readNews(NewsGatewayRequest $request): NewsGatewayResponse;
}
