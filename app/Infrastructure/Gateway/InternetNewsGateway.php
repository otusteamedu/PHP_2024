<?php

namespace App\Infrastructure\Gateway;

use App\Application\Gateway\NewsGatewayInterface;
use App\Application\Gateway\NewsGatewayRequest;
use App\Application\Gateway\NewsGatewayResponse;

class InternetNewsGateway implements NewsGatewayInterface
{

    public function readNews(NewsGatewayRequest $request): NewsGatewayResponse
    {
        $fp = file_get_contents($request->url);
        if (!$fp)
            throw new \Exception('Url not accessible.');

        $res = preg_match("/<title>(.*)<\/title>/siU", $fp, $title_matches);
        if (!$res)
            throw new \Exception('Cant read title.');


        // Clean up title: remove EOL's and excessive whitespace.
        $title = preg_replace('/\s+/', ' ', $title_matches[1]);
        $title = trim($title);

        return new NewsGatewayResponse($title);
    }
}
