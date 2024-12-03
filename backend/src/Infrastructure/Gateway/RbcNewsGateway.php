<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway;

use App\Application\Gateway\NewsGatewayInterface;
use App\Application\Gateway\NewsGatewayRequest;
use App\Application\Gateway\NewsGatewayResponse;

class RbcNewsGateway implements NewsGatewayInterface
{
    public function getNews(NewsGatewayRequest $request): NewsGatewayResponse
    {
        $title = 'News Title ' . random_int(1000, 9999);

        return new NewsGatewayResponse($title, $request->url, new \DateTimeImmutable());
    }
}
