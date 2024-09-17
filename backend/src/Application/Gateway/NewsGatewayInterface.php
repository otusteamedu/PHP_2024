<?php

declare(strict_types=1);

namespace App\Application\Gateway;

interface NewsGatewayInterface
{
    public function getNews(NewsGatewayRequest $request): NewsGatewayResponse;
}
